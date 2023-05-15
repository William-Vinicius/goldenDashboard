class CookieHandler{
  
  cookieExists(cookieName) {
    var cookies = document.cookie;
    var cookiesArray = cookies.split(';');

    for (var cont = 0; cont < cookiesArray.length; cont++) {
      var cookie = cookiesArray[cont].trim();
      if (cookie.startsWith(cookieName + '=')) {
        return [true, cookie]; // Cookie Existe
      }
    }
    return false; // Cookie non Ecxiste
  }
    // Retorna o cookie pelo NamedNodeMap, só n sei se retorna cookie vencido
  getCookie(cookieName){

    var cookieData = this.cookieExists(cookieName);

    if(cookieData[0]){
      return cookieData[1].split('=')[1];
      }
  }

  setCookie(name, value, valDate){
    let cookieName = String(name);
    let cookieValue = value
    let cookieTime = new Date(Date.now() + Number(valDate)); 

    document.cookie = `${cookieName}=${cookieValue}; expires=${cookieTime.toUTCString()}; path=/; SameSite=none; secure`
  }
}

const ch = new CookieHandler();
// Classe de validação da chave de acesso + liberação do JSON
class ApiInfo{

// Variável Privada que é retornada na classe como autorização da API
  constructor(){
    let _auth;

    this.getAuth = () => {
      return _auth;
    }
    this.setAuth = (valor) => {
      _auth = valor;
    }
  }

  // Atualiza o um novo código para o auth
  async  GetNewToken(){ // Retorna uma nova autorização
    
    let token;

    const apiKey = ["x-api-key", "f6d7f7abb1ff0e3b1557db73427f33912a514cd63c0aeec9ae"];
    const loginData = [["login", "jogodeouro"], ["password", "2w308efh"]]; // Inutil por enquanto, mas pode ser útil

    var Head = new Headers();
    Head.append(apiKey[0], apiKey[1]);

    var Body = new FormData();
    Body.append("login", "jogodeouro");
    Body.append("password", "2w308efh");

    const requestOptions = {
      method: 'POST',
      headers: Head,
      body: Body,
      redirect: 'follow'
    };

    try { // Tenta utilizar a API e colocar na variável Token e retornar ele
      const response = await fetch("https://apiv2dev.sga.bet/integrations/user/login", requestOptions);
      const data = await response.json();
      token = data["token_jwt"];
      return token;
    } 
    catch (error) {
      console.log(error);
    }
    // return token;
  }

// Função principal que insere valor e atualiza o auth
  async setAuthCookie() {
    const nameCookie = "sgaApiKey";
    const timeCookie = .1 * 60 * 60 * 1000; // 6 min
    // const timeCookie = 1 * 60 * 60 * 1000; // 1h


    if (!ch.cookieExists(nameCookie)[0]) {
      this.setAuth(await this.GetNewToken());

      ch.setCookie(nameCookie, this.getAuth(), timeCookie);
    } 
    else {
      ch.getCookie(nameCookie);
      console.log("Cookie Detectado")
    }
  }


}