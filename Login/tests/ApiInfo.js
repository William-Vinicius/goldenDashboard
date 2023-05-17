class CookieHandler{

    cookieExists(cookieName) {
        var cookies = document.cookie
        var cookiesArray = cookies.split(';')
        
        for (var cont = 0; cont < cookiesArray.length; cont++) {
            var cookie = cookiesArray[cont].trim()
            if (cookie.startsWith(cookieName + '=')) {
                return [true, cookie] // Cookie Existe
            }
        }
        return false // Cookie non Ecxiste
    }

        // Retorna o valor do cookie caso ele exista.
    getCookie(cookieName){
        var cookieData = this.cookieExists(cookieName)
        
        if(cookieData[0]){
            return cookieData[1].split('=')[1]
        }
    }
    
    setCookie(name, value, valDate){
        let cookieName = String(name)
        let cookieValue = value
        let cookieTime = new Date(Date.now() + Number(valDate)) 
        
        document.cookie = `${cookieName}=${cookieValue}; expires=${cookieTime.toUTCString()}; path=/; SameSite=none; secure`
    }
}
const ch = new CookieHandler()
    
// Classe de validação da chave de acesso + liberação do JSON
class ApiInfo{
    
    constructor() {
        this.authHandlerInstance = this.authHandler()
    }
    
    // Variável Privada que é retornada na classe como autorização da API
    authHandler() {
        let auth
        
        return {
            getAuth: async () => {
                return auth
            },
            
            setAuth: (valor) => {
                auth = valor
            }
        }
    }
    
    // Atualiza o um novo código para o auth
    async  GetNewToken(){ // Retorna uma nova autorização
    
        let token = "Teste"
        
        const apiKey = ["x-api-key", "f6d7f7abb1ff0e3b1557db73427f33912a514cd63c0aeec9ae"]
        const loginData = [["login", "jogodeouro"], ["password", "2w308efh"]] // Inutil por enquanto, mas pode ser útil
        
        var Head = new Headers()
            Head.append(apiKey[0], apiKey[1])
        
        var Body = new FormData()
            Body.append("login", "jogodeouro")
            Body.append("password", "2w308efh")
        
        const requestOptions = {
            method: 'POST',
            headers: Head,
            body: Body,
            redirect: 'follow'
        }
        
        try { // Tenta utilizar a API e colocar na variável Token e retornar ele
            const response = await fetch("https://apiv2dev.sga.bet/integrations/user/login", requestOptions)
            const data = await response.json()
            token = data["token_jwt"]
            return token
        }
        catch (error) {
            console.log(error)
        }
    }
    
    // Função principal que insere valor no Cookie e/ou atualiza o auth
    async setAuthCookie() {
        const nameCookie = "sgaApiKey"
        const timeCookie = .05 * 60 * 60 * 1000 // 6 min
        // const timeCookie = 5 * 60 * 60 * 1000 // 5h
        let token = this.authHandlerInstance.getAuth()
        
        if (!ch.cookieExists(nameCookie)[0]) {
            token = await this.GetNewToken()
            this.authHandlerInstance.setAuth(token)
            ch.setCookie(nameCookie, token, timeCookie)
            console.log("Cookie Atualizado")
        } 
        else {
            ch.getCookie(nameCookie)
            this.authHandlerInstance.setAuth(ch.getCookie(nameCookie))
            console.log("Cookie Detectado. mantendo a autorização para: " + await this.authHandlerInstance.getAuth())
        }
    }
    
    // Função que retorna uma array com todos os dados do sistema seguindo um período determinado pela data de inicio e final
    async useApi(dateStart, dateEnd, infoList = 0){
        let table = "Teste"
        await this.setAuthCookie()
        
        const apiKey = ["x-api-key", "f6d7f7abb1ff0e3b1557db73427f33912a514cd63c0aeec9ae"]
        const headerRequest = ['Application-Authorization', await this.authHandlerInstance.getAuth()]
        
        switch(infoList){
            case 0: // Usuários
                infoList = "https://apiv2dev.sga.bet/integrations/players/listInfos" 
                dateStart = ["start_date", dateStart]
                dateEnd = ["final_date", dateEnd]
            break
            
            case 1: // Apostas esportivas
                infoList = "https://apiv2dev.sga.bet/integrations/bets/list"
                dateStart = ["date_start", dateStart]
                dateEnd = ["date_final", dateEnd]
            break
            
            case 2: // Apostas Cassino
                infoList = "https://apiv2dev.sga.bet/integrations/bets/casino"
                dateStart = ["start_date", dateStart]
                dateEnd = ["final_date", dateEnd]
                break

            default:
                //Aviso de erro
                console.log("Erro ao informar a lista desejada")
            break
        }
        
        var Head = new Headers()
            Head.append(apiKey[0], apiKey[1]) 
            Head.append(headerRequest[0], headerRequest[1])
        
        var Body = new FormData()
            Body.append(dateStart[0], dateStart[1])
            if(headerRequest[1] )
            Body.append(dateEnd[0], dateEnd[1])
        
        const requestOptions = {
            method: 'POST',
            headers: Head,
            body: Body,
            redirect: 'follow'
        }
        
        try { // Tenta utilizar a API e colocar na variável table e retornar ele
            const response = await fetch(infoList, requestOptions)
            const result = await response.json()
            table = result["data"]
            console.log(table)
            return table['bet_id']
        }
        catch (error) {
            console.log(error)
        }

        return table
    }

    dataFilter(dataArray, filterString = "") { //filtra os dados de uma lista, mostrando todas as sub-arrays se houver
        filterString = filterString.toLowerCase()

        const filteredArray = dataArray.filter(valores =>
            Array.isArray(valores)
            ? valores.some(valor => valor.toLowerCase().includes(filterString))
            : valores.toLowerCase().includes(filterString)
        )

        console.log(filteredArray)
        return filteredArray
    }
    
    ShowDataTable(dataObject, titles){ // 
        dataObject = [{'id': 1, 'name': "Mango"}, {'id': 2, 'name': "Apple"}, {'id': 3, 'name': "cherry"}]
        titles = ['Id', 'Name']

        const dataArray = dataObject.map(obj => Object.values(obj).map(value => String(value))) // trocando o objeto para uma array
        let tabelaHTML = '<table><tr>'

        titles.forEach(data => {
            tabelaHTML += '<td>' + data + '</td>'
        })
        
        dataArray.forEach(valuesArray => {
            tabelaHTML += '<tr>';

            valuesArray.forEach(value => {
                tabelaHTML += '<td>' + value + '</td>';
            });
            tabelaHTML += '</tr>';
        });

        tabelaHTML += '</table>';
        console.log(dataArray[0].length)
        document.querySelector('#tabela').innerHTML = tabelaHTML;

    }

}