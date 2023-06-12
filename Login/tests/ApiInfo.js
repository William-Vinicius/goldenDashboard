// Classe para configuração dos cookies
class CookieHandler{

    cookieExists(cookieName) {
        var cookies = document.cookie
        var cookiesArray = cookies.split(';')
        
        for (var i = 0; i < cookiesArray.length; i++) {
            var cookie = cookiesArray[i].trim()
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
    
    constructor() { // Feito para conseguir chamar variável privada "auth"
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
        
        //Declarando variável e atribuindo valor caso fetch falhe
        let token = "Erro"
        
        const apiKey = ["x-api-key", "f6d7f7abb1ff0e3b1557db73427f33912a514cd63c0aeec9ae"]
        const loginData = [["login", "jogodeouro"], ["password", "2w308efh"]] // Inutil por enquanto, mas pode ser útil
        
        //Head do HTTP request
        var Head = new Headers()
            Head.append(apiKey[0], apiKey[1])
        
        // Body do HTTP Request
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
    async useApi(dateStart, dateEnd, infoList){
        console.log(infoList)


        let table = "Teste"
        let dateString

        await this.setAuthCookie()
        
        const apiKey = ["x-api-key", "f6d7f7abb1ff0e3b1557db73427f33912a514cd63c0aeec9ae"]
        const headerRequest = ['Application-Authorization', await this.authHandlerInstance.getAuth()]
        
        switch(infoList){
            case 0: // Usuários
                infoList = "https://apiv2dev.sga.bet/integrations/players/listInfos" 
                dateString = {start: "start_date", final: "final_date"}
            break
            
            case 1: // Apostas esportivas
                infoList = "https://apiv2dev.sga.bet/integrations/bets/list"
                dateString = {start: "date_start", final: "date_final"}
            break
            
            case 2: // Apostas Cassino
                infoList = "https://apiv2dev.sga.bet/integrations/bets/casino"
                dateString = {start: "start_date", final: "final_date"}                
                break

            default:
                //Aviso de erro
                console.log("Erro ao informar a lista desejada")
            break
        }

        // read do HTTP Request
        const Head = new Headers()
        Head.append(apiKey[0], apiKey[1]) 
        Head.append(headerRequest[0], headerRequest[1])

        async function getApiData(Body){

            let requestOptions = {
                method: 'POST',
                headers: Head,
                body: Body,
                redirect: 'follow'
            }
            if(infoList == 2){
                try { // Tenta utilizar a API e colocar na variável table e retornar ele
                    const response = await fetch(infoList, requestOptions)
                    const result = await response.json()
                    let data = result["list"]
                    console.log(data)
                    return data
                }
                catch (error) {
                    console.log(error)
                }
            }
            else {
                try { // Tenta utilizar a API e colocar na variável table e retornar ele
                    const response = await fetch(infoList, requestOptions)
                    const result = await response.json()
                    let data = result["data"]
                    console.log(data)
                    return data
                }
                catch (error) {
                    console.log(error)
                }
            }
        }

        function Hold(sec = 1) {
            const time = sec * 1000
            return new Promise((resolve) => {
              setTimeout(resolve, time)
            });
          }
          

        async function dateDivision(start, end){

            // Converte data para string para usar
            function date2String(date,beggining, time){
                var newdate = date.toISOString().replace("T", " ").slice(0, -13)
                if(!time.active){
                    if(beggining == true){
                        newdate = `${newdate}00:00:00`
                    }
                    else{
                        newdate = `${newdate}23:59:59`
                    }
                }
                else{
                    const dayStart = time.i
                    const dayBreak = time.i + time.pace

                    if(beggining == true){
                        if(dayStart < 10){
                            newdate = `${newdate}0${dayStart}:00:00`
                        }
                        else{
                            newdate = `${newdate}${dayStart}:00:00`
                        }
                    }
                    else{
                        if(dayBreak < 10){
                            newdate = `${newdate}0${dayBreak}:59:59`
                        }
                        else{
                            if(dayBreak > 23){
                                dayBreak = 23
                                
                            }
                            newdate = `${newdate}${dayBreak}:59:59`
                        }
                    }
                    time.i = time.i + time.pace
                }
                return newdate
            }

            let sDate = new Date(start)
            let fDate = new Date(end)
            let data = []

            let timeConfig = {
                active:false,
                i: 0,
                pace: 23,
            }

            for(sDate; sDate <= fDate; sDate.setDate(sDate.getDate() + 1)){
                if(timeConfig.active){
                }
                    start = date2String(sDate,true, timeConfig)
                    end = date2String(sDate,false, timeConfig)

                    console.log(start,end)
                
                    // Body do HTTP Request
                    var Body = new FormData()
                        Body.append(dateString.start, start)
                        Body.append(dateString.final, end)

                    console.log(Body)
                    data = await getApiData(Body)
                    Hold()
            }
            // i = 0
            return data
       }

       table = await dateDivision('2023-05-01 00:00:00' , '2023-05-01 23:59:59')



        console.log(table)
        return table
    }

    dataFilter(dataArray, filterString = "") { //filtra os dados de uma lista, mostrando todas as sub-arrays se houver, Não utilizado ainda 
        filterString = filterString.toLowerCase()

        const filteredArray = dataArray.filter(data =>
            Array.isArray(data)
            ? data.some(valor => valor.toLowerCase().includes(filterString))
            : data.toLowerCase().includes(filterString)
        )

        console.log(filteredArray)
        return filteredArray
    }
    
    
}

const api = new ApiInfo()
class DataWorks{

    drawDataTable(dataArray, titles){ // Coloca a array em formato de tabela

        let tabelaHTML = '<table><tr>'

        titles.forEach(data => {
            tabelaHTML += '<th>' + data + '</th>'
        })
        
        dataArray.forEach(valuesArray => {
            tabelaHTML += '<tr>'

            valuesArray.forEach(value => {
                tabelaHTML += '<td>' + value + '</td>'
            })
            tabelaHTML += '</tr>'
        })

        tabelaHTML += '</table>'
        console.log(dataArray[0].length)
        document.querySelector('#tabela').innerHTML = tabelaHTML
        
        let tbStyle = document.querySelector('#tabela table').style

        tbStyle.backgroundColor = "#00000066"
        tbStyle.textAlign = "left"
        tbStyle.borderCollapse = "collapse"


    }
    
    async getTopPlayersArray(dateStart, dateEnd, infoList){
        
        const dataObj = await api.useApi(dateStart, dateEnd, infoList)

        // Retorna uma array com a as informações agrupadas pelo id do Apostador
        function getApiArrays(choice = 2) {

            if(choice == 1){ // Esportes
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

            else if(choice == 2){ // Casino

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
        // Consfigurando para ficar uma array com a adição do objeto com a soma das colunas solicitadas
        let faturamento = getApiArrays(infoList)
        
        // Retorna o array de getApiArrays, junto ao  
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
        faturamento.sort((a,b) => b[Number(4)] - a[Number(4)])

        return faturamento
    }

    async formactTable(dataChoice){ // Configurar as tabelas e deixar de forma bonita
        // Pega os dados dos input com os Ids abaixo
        let startDate = document.querySelector('#dtInicio').value
        let endDate = document.querySelector('#dtFinal').value

        startDate = String(startDate)
        endDate = String(endDate)
        
        console.log(startDate)
        console.log(endDate)

        let dataArray = await this.getTopPlayersArray(endDate,startDate,dataChoice)
        let title = ["Id Jogador", "Valor Total Apostado", "Valor total Premiado", "Quantidade de apostas", "Ggr Total"]

        dataArray = dataArray.map(([id, positiveValue, negativeValue, count, combinedValue]) =>{
            return [
                id,
                positiveValue.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }),
                negativeValue.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }),
                count,
                combinedValue.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' }),
            ]})

        this.drawDataTable(dataArray, title)
    }
}