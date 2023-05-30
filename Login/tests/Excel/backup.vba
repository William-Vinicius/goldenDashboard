Function wsExists(name As String) As Boolean
    Dim ws As Worksheet
    For Each ws In ThisWorkbook.Worksheets
        If ws.name = name Then
            wsExists = True
            Exit Function
        End If
    Next ws
    wsExists = False
End Function

Private Sub btAfiliate_Click()
MsgBox "Aguardando implementação da SGA"
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

    Dim confirm As Boolean
    confirm = wsExists("ConfigDate")

    If confirm Then
        Set ws = ThisWorkbook.Sheets("ConfigDate")         
    Else
        MsgBox ("A página de configuração está sendo criada. Insira as datas nas células abaixo de 'Data Inicial' e 'Data Final' na Planilha Config.")
        Set ws = ThisWorkbook.Sheets.Add
        ws.name = "ConfigDate"
        ws.Cells(1,1).Value = "Data Inicial"
        ws.Cells(1,2).Value = "Data Final"
        Exit Sub
    End If


    Set ws = ThisWorkbook.Sheets("ConfigDate") ' Substitua "ConfigDate" pelo nome da planilha desejada

    On Error GoTo ErrorHandler
    
    lbInvAuth.Caption = jsonObject("token_jwt")
    lbMessage.Caption = "Chave adquirida com sucesso"
    

    
    ' Mostrando os Valores das datas inseridas para verificação
    Dim date1, date2 As Variant
    Dim dtStart, dtEnd As Date
    
    ' Substitua "ConfigDate" pelo nome da sua planilha
        
    dtStart = ws.Cells(2, 1).Value
    dtEnd = ws.Cells(2, 2).Value

    lbStart = CStr(dtStart) & " 00:00:00"
    lbEnd = CStr(dtEnd) & " 23:59:59"
    
    Exit Sub

ErrorHandler:
        MsgBox "Ocorreu um erro durante a solicitação HTTP: " & Err.Description
End Sub

Private Sub btSportBet_Click()

    Dim cont As Long
    Dim wss As Worksheet
    Dim auth
    auth = lbInvAuth.Caption
    Dim dtStart, dtEnd As Date
    
    StartString = "date_start" ' {{DateStart stxring}}
    EndString = "date_final" ' {{DateEnd string}}
    
    ' Pegando os valores de data de início e de Final
    dtStart = ThisWorkbook.Sheets("ConfigDate").Cells(2, 1).Value
    dtEnd = ThisWorkbook.Sheets("ConfigDate").Cells(2, 2).Value
    
    ' Verificar se já existe a tabela "Bets Esportivos", se não tiver ele cria
    Dim confirm As Boolean
    confirm = wsExists("Bets Esportivos")
    
    If confirm Then
    
        confirm = (MsgBox("A planilha 'Bets Esportivos' já foi encontrada, sendo assim, ela será subscrita, tem certeza que quer continuar?", vbYesNo) = vbYes)
        If confirm Then

            Set wss = ThisWorkbook.Sheets("Bets Esportivos") ' Substitua "ConfigDate" pelo nome da planilha desejada
        Else
        
            lbMessage = "Processo interrompido pelo usuário"
            Exit Sub
        End If
        
    Else
        Set wss = ThisWorkbook.Sheets.Add
        wss.name = "Bets Esportivos"
    End If
        
    cont = 1
    
    ' Título
    wss.Cells(cont, 1) = "Id Aposta"
    wss.Cells(cont, 2) = "Id Usuário"
    wss.Cells(cont, 3) = "Login Usuário"
    wss.Cells(cont, 4) = "Quantidade Eventos"
    wss.Cells(cont, 5) = "Data da Aposta"
    wss.Cells(cont, 6) = "Data do Resultado"
    wss.Cells(cont, 7) = "Valor apostado"
    wss.Cells(cont, 8) = "Valor da Premiação"
    wss.Cells(cont, 9) = "Toatal das Odds"
    wss.Cells(cont, 10) = "Resultado da Aposta"
    wss.Cells(cont, 11) = "Tipo da Aposta"
    wss.Cells(cont, 12) = "Status da Aposta"
    
    cont = cont + 1
    
    If Len(auth) > 1 Then
        If Len(dtStart) > 1 And Len(dtEnd) > 1 Then
            Do While dtStart <= dtEnd
            
                dy = CStr(Day(dtStart))
                mt = CStr(Month(dtStart))
                yr = CStr(Year(dtStart))
            
                altDtStart = yr & "-" & mt & "-" & dy
                altStart = altDtStart & " 00:00:00"
                altEnd = altDtStart & " 23:59:59"
                
                fullDateStart = StartString & "=" & altStart
                fullDateEnd = EndString & "=" & altEnd
                
                Url = "https://apiv2dev.sga.bet/integrations/bets/list" ' {{Url}}
                Set objHTTP = CreateObject("WinHttp.WinHttpRequest.5.1")
                objHTTP.Open "POST", Url, False
                
                ' Header do Http Request
                objHTTP.setRequestHeader "Content-Type", "application/x-www-form-urlencoded"
                objHTTP.setRequestHeader "x-api-key", "f6d7f7abb1ff0e3b1557db73427f33912a514cd63c0aeec9ae"
                objHTTP.setRequestHeader "Application-Authorization", auth
                
                ' Body do Http Request
                postData = fullDateStart & "&" & fullDateEnd ' {{dateStart}} + {{dateFinal}}
                            
                'Executando o request
                objHTTP.Send postData
                
                On Error GoTo ErrorHandler
                
                'Trabalhando os dados Retornados
                strResult = objHTTP.responseText
                json = strResult
                Set jsonObject = JsonConverter.ParseJson(json)
                
                Dim info
                info = "data"
                            
                For Each bet In jsonObject(info) ' {{dados}}
                
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
            lbMessage = "Tabela Preenchida com Sucesso!"
        Else
            MsgBox "Erro: Não foi possível alcançar as datas inicial e/ou final"
    End If
    Else
        MsgBox "Erro ao alcançar autorização do servidor"
    End If
    Exit Sub
    
ErrorHandler:
    MsgBox "Ocorreu um erro durante a solicitação HTTP: " & Err.Description
    
End Sub

Function getApiData(StartString As String, EndString As String, UrlBase As String, wsName As String, Inform As String, dataNames() As Variant, Titles() As Variant)

    Dim cont As Long
    Dim wss As Worksheet
    Dim auth
    Dim dtStart, dtEnd As Date

    auth = lbInvAuth.Caption
    cont = 1
    
    ' Pegando os valores de data de início e de Final
    dtStart = ThisWorkbook.Sheets("ConfigDate").Cells(2, 1).Value
    dtEnd = ThisWorkbook.Sheets("ConfigDate").Cells(2, 2).Value
    
    ' Verificar se já existe a tabela "Bets Esportivos", se não tiver ele cria
    Dim confirm As Boolean
    confirm = wsExists(wsName)
    
    If confirm Then
    
        confirm = (MsgBox("A planilha " & wsName & " já foi encontrada, sendo assim, ela será subscrita, tem certeza que quer continuar?", vbYesNo) = vbYes)
        If confirm Then

            Set wss = ThisWorkbook.Sheets(wsName)
        Else
        
            lbMessage = "Processo interrompido pelo usuário"
            Exit Function
        End If
        
    Else
        Set wss = ThisWorkbook.Sheets.Add
        wss.name = wsName
    End If
        
    
    
    ' Título
    Dim i As Integer
    
    i = 1
    For Each Row In Titles
        wss.Cells(cont, i).Value = Row
        
        i = i + 1
    Next
    cont = cont + 1
    i = 1
    
    If Len(auth) > 1 Then
        If Len(dtStart) > 1 And Len(dtEnd) > 1 Then
            Do While dtStart <= dtEnd
            
                dy = CStr(Day(dtStart))
                mt = CStr(Month(dtStart))
                yr = CStr(Year(dtStart))
            
                altDtStart = yr & "-" & mt & "-" & dy
                altStart = altDtStart & " 00:00:00"
                altEnd = altDtStart & " 23:59:59"
                
                fullDateStart = StartString & "=" & altStart
                fullDateEnd = EndString & "=" & altEnd
                
                Set objHTTP = CreateObject("WinHttp.WinHttpRequest.5.1")

                MsgBox UrlBase

                objHTTP.Open "POST", UrlBase, False
                
                ' Header do Http Request
                objHTTP.setRequestHeader "Content-Type", "application/x-www-form-urlencoded"
                objHTTP.setRequestHeader "x-api-key", "f6d7f7abb1ff0e3b1557db73427f33912a514cd63c0aeec9ae"
                objHTTP.setRequestHeader "Application-Authorization", auth
                
                ' Body do Http Request
                postData = fullDateStart & "&" & fullDateEnd ' {{dateStart}} + {{dateFinal}}
                            
                'Executando o request
                objHTTP.Send postData
                
                'Trabalhando os dados Retornados
                strResult = objHTTP.responseText
                json = strResult
                Set jsonObject = JsonConverter.ParseJson(json)
                
                            
                For Each bet In jsonObject("data") ' {{dados}}
                    For Each Row In dataNames
                        wss.Cells(cont, i) = bet(Row)
                        i = i + 1
                    Next
                    i = 1
                    cont = cont + 1
                Next

            dtStart = dtStart + 1
            Loop
            lbMessage = "Tabela Preenchida com Sucesso!"
        Else
            MsgBox "Erro: Não foi possível alcançar as datas inicial e/ou final"
    End If
    Else
        MsgBox "Erro ao alcançar autorização do servidor"
    End If
    Exit Function
    
End Function

Private Sub btCasinoBet_Click()
    Dim StartString As String
    Dim EndString As String
    Dim Url As String
    Dim wsName As String
    Dim Inform As String
    Dim dataNames() As Variant ' Declaração do array de strings
    Dim Titles() As Variant

    StartString = "start_date" ' {{DateStart stxring}}
    EndString = "final_date"
    Url = "https://apiv2dev.sga.bet/integrations/bets/casino"
    wsName = "Bets do Cassino"
    Inform = "data(list)"
    dataNames = Array("player_id", "operation_id", "operation_name", "Value", "Date", "game", "game_id")
    Titles = Array("Id do Player", "id do Jogo", "Nome da Operação", "Valor Apostado", "Data da Aposta", "Nome do Jogo", "id do Jogo")
    
     Dim cont As Long
    Dim wss As Worksheet
    Dim auth
    Dim dtStart, dtEnd As Date

    auth = lbInvAuth.Caption
    cont = 1
    
    ' Pegando os valores de data de início e de Final
    dtStart = ThisWorkbook.Sheets("ConfigDate").Cells(2, 1).Value
    dtEnd = ThisWorkbook.Sheets("ConfigDate").Cells(2, 2).Value
    
    ' Verificar se já existe a tabela "Bets Esportivos", se não tiver ele cria
    Dim confirm As Boolean
    confirm = wsExists(wsName)
    
    If confirm Then
    
        confirm = (MsgBox("A planilha " & wsName & " já foi encontrada, sendo assim, ela será subscrita, tem certeza que quer continuar?", vbYesNo) = vbYes)
        If confirm Then

            Set wss = ThisWorkbook.Sheets(wsName)
        Else
        
            lbMessage = "Processo interrompido pelo usuário"
            Exit Sub
        End If
        
    Else
        Set wss = ThisWorkbook.Sheets.Add
        wss.name = wsName
    End If
        
    
    
    ' Título
    Dim i As Integer
    
    i = 1
    For Each Row In Titles
        wss.Cells(cont, i).Value = Row
        
        i = i + 1
    Next
    cont = cont + 1
    i = 1
    
    If Len(auth) > 1 Then
        If Len(dtStart) > 1 And Len(dtEnd) > 1 Then
            Do While dtStart <= dtEnd
            
                dy = CStr(Day(dtStart))
                mt = CStr(Month(dtStart))
                yr = CStr(Year(dtStart))
            
                altDtStart = yr & "-" & mt & "-" & dy
                altStart = altDtStart & " 00:00:00"
                altEnd = altDtStart & " 23:59:59"
                
                fullDateStart = StartString & "=" & altStart
                fullDateEnd = EndString & "=" & altEnd
                
                Set objHTTP = CreateObject("WinHttp.WinHttpRequest.5.1")

                MsgBox UrlBase

                objHTTP.Open "POST", Url, False
                
                ' Header do Http Request
                objHTTP.setRequestHeader "Content-Type", "application/x-www-form-urlencoded"
                objHTTP.setRequestHeader "x-api-key", "f6d7f7abb1ff0e3b1557db73427f33912a514cd63c0aeec9ae"
                objHTTP.setRequestHeader "Application-Authorization", auth
                
                ' Body do Http Request
                postData = fullDateStart & "&" & fullDateEnd ' {{dateStart}} + {{dateFinal}}
                            
                'Executando o request
                objHTTP.Send postData
                
                'Trabalhando os dados Retornados
                strResult = objHTTP.responseText
                json = strResult
                Set jsonObject = JsonConverter.ParseJson(json)
    
                Set jsonObject = jsonObject("data")
                            
                For Each bet In jsonObject("list") ' {{dados}}
                    For Each Row In dataNames
                        wss.Cells(cont, i) = bet(Row)
                        i = i + 1
                    Next
                    i = 1
                    cont = cont + 1
                Next

            dtStart = dtStart + 1
            Loop
            lbMessage = "Tabela Preenchida com Sucesso!"
        Else
            MsgBox "Erro: Não foi possível alcançar as datas inicial e/ou final"
    End If
    Else
        MsgBox "Erro ao alcançar autorização do servidor"
    End If
End Sub


Private Sub btUser_Click()

    Dim StartString As String
    Dim EndString As String
    Dim Url As String
    Dim wsName As String
    Dim Inform As String
    Dim dataNames() As Variant ' Declaração do array de strings
    Dim Titles() As Variant

    StartString = "start_date" ' {{DateStart stxring}}
    EndString = "final_date"
    Url = "https://apiv2dev.sga.bet/integrations/players/listInfos"
    wsName = "Usuários do Site"
    Inform = "data"
    dataNames = Array("user_id", "user_name", "status", "register_date", "last_login", "online_balance", "bonus_balance", "reliability_factor", "phone", "email", "first_deposit_date", "last_deposit_date", "affiliate_id", "affiliate_name", "regional_id", "regional_namem", "local_id", "local_name")
    Titles = Array("Id do Usuário", "Nome do Usuário", "status", "Data de Registro", "Ultimo login", "Saldo na conta ", "Saldo Bônus", "Fator de confiabilidade", "Telefone", "E-mail", "Data Primiero Depósito", "Data Ultimo Depósito", "Id Afiliado", "Nome Afiliado", "Id Gestor Regional", "Nome Gestor Regional", "Id Gestor Local", "Nome Gestor Local")
    
        Dim cont As Long
    Dim wss As Worksheet
    Dim auth
    Dim dtStart, dtEnd As Date

    auth = lbInvAuth.Caption
    cont = 1
    
    ' Pegando os valores de data de início e de Final
    dtStart = ThisWorkbook.Sheets("ConfigDate").Cells(2, 1).Value
    dtEnd = ThisWorkbook.Sheets("ConfigDate").Cells(2, 2).Value
    
    ' Verificar se já existe a tabela "Bets Esportivos", se não tiver ele cria
    Dim confirm As Boolean
    confirm = wsExists(wsName)
    
    If confirm Then
    
        confirm = (MsgBox("A planilha " & wsName & " já foi encontrada, sendo assim, ela será subscrita, tem certeza que quer continuar?", vbYesNo) = vbYes)
        If confirm Then

            Set wss = ThisWorkbook.Sheets(wsName)
        Else
        
            lbMessage = "Processo interrompido pelo usuário"
            Exit Sub
        End If
        
    Else
        Set wss = ThisWorkbook.Sheets.Add
        wss.name = wsName
    End If
    
    ' Título
    Dim i As Integer
    
    i = 1
    For Each Row In Titles
        wss.Cells(cont, i).Value = Row
        
        i = i + 1
    Next
    cont = cont + 1
    i = 1
    
    If Len(auth) > 1 Then
        If Len(dtStart) > 1 And Len(dtEnd) > 1 Then
            Do While dtStart <= dtEnd
            
                dy = CStr(Day(dtStart))
                mt = CStr(Month(dtStart))
                yr = CStr(Year(dtStart))
            
                altDtStart = yr & "-" & mt & "-" & dy
                altStart = altDtStart & " 00:00:00"
                altEnd = altDtStart & " 23:59:59"
                
                fullDateStart = StartString & "=" & altStart
                fullDateEnd = EndString & "=" & altEnd
                
                Set objHTTP = CreateObject("WinHttp.WinHttpRequest.5.1")

                MsgBox UrlBase

                objHTTP.Open "POST", Url, False
                
                ' Header do Http Request
                objHTTP.setRequestHeader "Content-Type", "application/x-www-form-urlencoded"
                objHTTP.setRequestHeader "x-api-key", "f6d7f7abb1ff0e3b1557db73427f33912a514cd63c0aeec9ae"
                objHTTP.setRequestHeader "Application-Authorization", auth
                
                ' Body do Http Request
                postData = fullDateStart & "&" & fullDateEnd ' {{dateStart}} + {{dateFinal}}
                            
                'Executando o request
                objHTTP.Send postData
                
                'Trabalhando os dados Retornados
                strResult = objHTTP.responseText
                json = strResult
                Set jsonObject = JsonConverter.ParseJson(json)
                
                            
                For Each bet In jsonObject("data") ' {{dados}}
                    For Each Row In dataNames
                        wss.Cells(cont, i) = bet(Row)
                        i = i + 1
                    Next
                    i = 1
                    cont = cont + 1
                Next

            dtStart = dtStart + 1
            Loop
            lbMessage = "Tabela Preenchida com Sucesso!"
        Else
            MsgBox "Erro: Não foi possível alcançar as datas inicial e/ou final"
    End If
    Else
        MsgBox "Erro ao alcançar autorização do servidor"
    End If
    
    
End Sub