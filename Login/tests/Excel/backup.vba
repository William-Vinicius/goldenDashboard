Private Sub CommandButton1_Click()
    
    Dim json As String
    Dim jsonObject As Object, item As Object
    Dim i As Long
    Dim ws As Worksheet
    Dim objHTTP As Object

    Set objHTTP = CreateObject("WinHttp.WinHttpRequest.5.1")
    
Private Sub btCasinoBet_Click()
Dim etad As Date

etad = ThisWorkbook.Sheets("Planilha1").Cells(2, 2).Value

MsgBox etad

etad = etad + 1

MsgBox etad
End Sub

Private Sub UserForm_Initialize()
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
    

    
    ' Mostrando os Valores das datas inseridas para verificação
    Dim date1, date2 As Variant
    Dim dtStart, dtEnd As Date
    
    ' Substitua "Planilha1" pelo nome da sua planilha
        
    dtStart = ws.Cells(2, 1).Value
    dtEnd = ws.Cells(2, 2).Value
    
    MsgBox dtStart

    lbStart = CStr(dtStart) & " 00:00:00"
    lbEnd = CStr(dtEnd) & " 23:59:59"
    
    Exit Sub

ErrorHandler:
        MsgBox "Ocorreu um erro durante a solicitação HTTP: " & Err.Description
    Resume Next
    
End Sub

Private Sub btSportBet_Click()

    Dim cont As Long
    Dim wss As Worksheet
    Dim auth
    auth = lbInvAuth.Caption
    
    StartString = "date_start" ' {{DateStart stxring}}
    EndString = "date_final" ' {{DateEnd string}}
    
    
    
    
    If Len(auth) > 1 Then
        If Len(lbStart) > 1 And Len(lbEnd) > 1 Then
            Do While dtStart <= dtEnd
            
                MsgBox (dtStart)
            
                dy = CStr(Day(dtStart))
                mt = CStr(Month(dtStart))
                yr = CStr(Year(dtStart))
            
                altDtStart = yr & "-" & mt & "-" & dy

                altStart = altDtStart & " 00:00:00"
                altEnd = altDtStart & " 23:59:59"
                
                fullDateStart = StartString & "=" & altStart
                fullDateEnd = EndString & "=" & altEnd
                            
            
                Set objHTTP = CreateObject("WinHttp.WinHttpRequest.5.1")
                
                Url = "https://apiv2dev.sga.bet/integrations/bets/list" ' {{Url}}
                
                objHTTP.Open "POST", Url, False
                
                objHTTP.setRequestHeader "Content-Type", "application/x-www-form-urlencoded"
                objHTTP.setRequestHeader "x-api-key", "f6d7f7abb1ff0e3b1557db73427f33912a514cd63c0aeec9ae"
                objHTTP.setRequestHeader "Application-Authorization", auth
                
                postData = fullDateStart & "&" & fullDateEnd ' {{dateStart}} + {{dateFinal}}
                            
                objHTTP.Send postData
                strResult = objHTTP.responseText
                
                json = strResult
                Set jsonObject = JsonConverter.ParseJson(json)
            
                Set wss = ThisWorkbook.Sheets("Planilha1") ' Substitua "Planilha1" pelo nome da planilha desejada
                cont = 5
                
                For Each bet In jsonObject("data") ' {{dados}}
                
                    wss.Cells(cont, 1) = bet("bet_id")
                    wss.Cells(cont, 2) = bet("user_id")
                    wss.Cells(cont, 3) = bet("user")
                    wss.Cells(cont, 4) = bet("num_events")
                    wss.Cells(cont, 5) = bet("bet_date")
                    wss.Cells(cont, 6) = bet("bet_result_date")
                    wss.Cells(cont, 7) = bet("bet_value")
                    wss.Cells(cont, 8) = bet("bet_prize_value")
                    wss.Cells(cont, 9) = bet("total_odd_multiplier")
                    wss.Cells(cont, 10) = bet("bet_result")
                    wss.Cells(cont, 11) = bet("bet_type")
                    wss.Cells(cont, 12) = bet("bet_status")
                    
                    cont = cont + 1
                Next

            dtStart = dtStart + 1
            Loop
        Else
            MsgBox "Erro: Não foi possível alcançar as datas inicial e/ou final"
    End If
    Else
        MsgBox "Erro ao alcançar autorização do servidor"
    End If
End Sub
