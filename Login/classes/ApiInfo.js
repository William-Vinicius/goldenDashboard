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
            return table
        }
        catch (error) {
            console.log(error)
        }

        console.log(table)
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
    
    drawDataTable(dataArray, titles){ // Coloca a array em formato de tabela

        let tabelaHTML = '<table><tr class = TableTitle>'

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
        let tableDiv = document.querySelector('#tabela')
        tableDiv.innerHTML = tabelaHTML;

        let table = document.querySelector('table').style
        table.borderCollapse = "collapse"
        table.border =  '2px solid #666dc5'
        let tbTitle = document.querySelector('.TableTitle').style
        tbTitle.backgroundColor = "#737DEB"
        tbTitle.padding = "1rem"
        tbTitle.fontWeight = "bold"

        let tbTd = document.querySelectorAll('table tr td')
        tbTd.forEach(function(td){
            td.style.border = "1px solid #666dc5"
            td.style.padding = ".5rem"
        })

        let tbTr = document.querySelectorAll('table tr')
        tbTd.forEach(function(td){
            td.style.borderbottom = "border: 1px solid #737DEB"
            td.style.textAlign = "center"
        })



    }
}

const api = new ApiInfo()
class DataWorks{

    async getTopPlayersArray(dateStart,dateEnd, infoList = 2){
        const dataObj = await api.useApi(dateStart, dateEnd, infoList)

        // Forma de Pegar uma coluna
        function getApiArrays() {
            if(infoList == 1){ // Esportes
                var column = dataObj.map(function(innerContent) {
                    return [
                        innerContent.user_id.slice(), innerContent.bet_value.slice(), innerContent.bet_result.slice(), innerContent.total_odd_multiplier.slice() 
                    ]
                })
    
                let map = column.reduce(
                    (accumulator, [id, value, condition, multi]) => {
                        accumulator[id] = accumulator[id] || {count: 0, positiveValue: 0, negativeValue: 0}
                    
                        accumulator[id].count++;
                        if(condition != "Pendent"){
                            if (condition == "Cashout" ) {
                                accumulator[id].positiveValue += Number(value)
                            }
                            else {
                                accumulator[id].positiveValue += Number(value)
                                accumulator[id].negativeValue += Number(value) * multi
                            }
                        }
        
                        return accumulator
                    },
                {})
                return Object.entries(map).map(([ id, { positiveValue, negativeValue, count }]) => [id, positiveValue, negativeValue, count])
            }
    
            else if(infoList == 2){ // Casino

                var column = dataObj.list.map(function(innerContent) {
                    return [
                        innerContent.player_id.slice(), innerContent.value.slice(), innerContent.operation_id.slice() 
                     ]
                })
    
                let map = column.reduce(
                    (accumulator, [id, value, condition]) => {
                        accumulator[id] = accumulator[id] || {count: 0, positiveValue: 0, negativeValue: 0}
                    
                        accumulator[id].count++;
                        if (condition == "101") {
                        accumulator[id].positiveValue += Number(value)
                        }
                        else {
                        accumulator[id].negativeValue += Number(value)
                        }
        
                        return accumulator
                    },
                {})
                return Object.entries(map).map(([ id, { positiveValue, negativeValue, count }]) => [id, positiveValue, negativeValue, count])
            }
        }

        // Retorna um objeto com a soma das colunas solicitadas
        
        // Consfigurando para ficar uma array com a adição do objeto com a soma das colunas solicitadas
        let faturamento = getApiArrays()
        
        faturamento = faturamento.map(([id, positiveValue, negativeValue, count]) =>{
            const combinedValue = positiveValue - negativeValue
            return [
                id,
                positiveValue, 
                negativeValue, 
                count, 
                combinedValue,
            ]
        })
        
        // Ordenar em ordem decrescente
        // faturamento.sort((a,b) => b[Number(4)] - a[Number(4)])

        return faturamento
    }

    async getDaylyactivityArray(dateStart,dateEnd, infoList){
        const dataObj = await api.useApi(dateStart, dateEnd, infoList)

        if(infoList == 1){ // Esportes
            var column = dataObj.map(function(innerContent) {
                return [
                    innerContent.bet_date.slice(), innerContent.bet_value.slice(), innerContent.bet_result.slice(), innerContent.total_odd_multiplier.slice() 
                ]
            })

            let map = column.reduce(
                (accumulator, [date, value, condition, multi]) => {
                    accumulator[date] = accumulator[date] || {count: 0, positiveValue: 0, negativeValue: 0}
                
                    accumulator[date].count++;
                    if(condition != "Pendent"){
                        if (condition == "Cashout" ) {
                            accumulator[date].positiveValue += Number(value)
                        }
                        else {
                            accumulator[date].positiveValue += Number(value)
                            accumulator[date].negativeValue += Number(value) * multi
                        }
                    }
    
                    return accumulator
                },
            {})
            return Object.entries(map).map(([ date, { positiveValue, negativeValue, count }]) => [date, positiveValue, negativeValue, count])
        }
        else if(infoList == 2){ // Casino

            var column = dataObj.list.map(function(innerContent) {
                return [
                    innerContent.date.slice(), innerContent.value.slice(), innerContent.operation_id.slice() 
                 ]
            })

            let map = column.reduce(
                (accumulator, [date, value, condition]) => {
                    accumulator[date] = accumulator[date] || {count: 0, positiveValue: 0, negativeValue: 0}
                
                    accumulator[date].count++;
                    if (condition == "101") {
                        accumulator[date].positiveValue += Number(value)
                    }
                    else {
                        accumulator[date].negativeValue += Number(value)
                    }
    
                    return accumulator
                },
            {})
            return Object.entries(map).map(([ date, { positiveValue, negativeValue, count }]) => [date, positiveValue, negativeValue, count])
        }
    }

    async formactTable(choiceValue){
        function BRLValue(value) {
            return Number(value).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
          }

        let startDate = document.querySelector('#dtInicio').value
        let endDate = document.querySelector('#dtFinal').value
        startDate = String(startDate) + " 00:00:00"
        endDate = String(endDate) + " 23:59:59" 

        console.log(startDate)
        console.log(endDate);

        let dataArray = await this.getTopPlayersArray(startDate, endDate,choiceValue)
        dataArray = dataArray.map(function(item) {
            return [
              item[0],
              BRLValue(item[1]),
              BRLValue(item[2]),
              item[3],
              BRLValue(item[4])
            ];
          });

        let title = ["Id Jogador", "Valor Total Apostado", "Valor total Premiado", "Quantidade de apostas", "Ggr Total"]

        api.drawDataTable(dataArray, title)

    }
}