function GetNewToken(){

  let token = "";
  let apiKey = ["x-api-key", "f6d7f7abb1ff0e3b1557db73427f33912a514cd63c0aeec9ae"];
  let loginData = [["login", "jogodeouro"], ["password", "2w308efh"]];

  var myHeaders = new Headers();
  myHeaders.append(apiKey[0], apiKey[1]);

  var formData = new FormData();
  formData.append("login", "jogodeouro");
  formData.append("password", "2w308efh");

  var requestOptions = {
    method: 'POST',
    headers: myHeaders,
    body: formData,
    redirect: 'follow'
  };

  // função para fazer a requisição e retornar uma promessa
  function fetchData() {
    return fetch("https://apiv2dev.sga.bet/integrations/user/login", requestOptions)
    .then(response => response.json())
    .then(response => {return response})
  }

  // função que usa a variável retornada pela promessa para estocar na var Token
  function useData(data) {
    token = data["token_jwt"]
  }

  // chama a função fetchData para obter os dados e, em seguida, chama a função useData com os dados retornados como parâmetro
  fetchData()
  .then(response => useData(response))
  .catch(error => console.log(error));

  return token
}

function SetTokenCookie(){

  function cookieExists(cookieName) {
    var cookies = document.cookie;
    var cookiesArray = cookies.split(';');

    // Procura o cookie específico pelo nome
    for (var cont = 0; cont < cookiesArray.length; cont++) {
      var cookie = cookiesArray[cont].trim();

      // Cookie Existe
      if (cookie.startsWith(cookieName + '=')) {
        return true;
      }
    }
    return false;

  }
}