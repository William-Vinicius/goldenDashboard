Private Sub CommandButton1_Click()
    
    Dim json As String
    Dim jsonObject As Object, item As Object
    Dim i As Long
    Dim ws As Worksheet
    Dim objHTTP As Object

    Set objHTTP = CreateObject("WinHttp.WinHttpRequest.5.1")
    
    Url = "https://apiv2dev.sga.bet/integrations/user/login"
    objHTTP.Open "POST", Url, False
    
    objHTTP.setRequestHeader "Content-Type", "application/x-www-form-urlencoded"
    objHTTP.setRequestHeader "x-api-key", "f6d7f7abb1ff0e3b1557db73427f33912a514cd63c0aeec9ae"
    postData = "login=jogodeouro&password=2w308efh"

    
    objHTTP.Send postData
    strResult = objHTTP.responseText
    
    json = strResult
    Set jsonObject = JsonConverter.ParseJson(json)

    Set ws = ThisWorkbook.Sheets("Planilha1") ' Substitua "Planilha1" pelo nome da planilha desejada

    On Error GoTo ErrorHandler
    
        lbInvAuth.Caption = jsonObject("token_jwt")
        lbMessage.Caption = "Chave adquirida com sucesso"
        
    Exit Sub

ErrorHandler:
        MsgBox "Ocorreu um erro durante a solicitação HTTP: " & Err.Description
        
End Sub


Private Sub CommandButton6_Click()

  Dim valor As Variant
    
    ' Substitua "Planilha1" pelo nome da sua planilha
    valor = ThisWorkbook.Sheets("Planilha1").Range("A1;A2").Text
    
    valor2 = lbInvAuth.Caption
    
    ' Faça algo com o valor obtido
    MsgBox "O valor da célula A2 é: " & valor

End Sub

