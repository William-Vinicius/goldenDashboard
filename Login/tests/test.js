function myFun(){

  let title = document.querySelector("h1")
  // title.innerHTML = "aaaaaaaa"

    var myHeaders = new Headers();
    myHeaders.append("x-api-key", "f6d7f7abb1ff0e3b1557db73427f33912a514cd63c0aeec9ae");

    var formData = new FormData();
    formData.append("login", "jogodeouro");
    formData.append("password", "2w308efh");

    var requestOptions = {
        method: 'POST',
        headers: myHeaders,
        body: formData,
        redirect: 'follow'
    };

    fetch("https://apiv2dev.sga.bet/integrations/user/login", requestOptions)
        .then(response => response.text())
        .then(data => {
          const resultado = data;
          console.log(resultado);
        })
        .catch(error => console.error(error));
    
    const logbook = resultado
    
}
