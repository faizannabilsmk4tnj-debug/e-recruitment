$raw = Get-Content "c:\laragon\laravel\e-recruitment\memory claude\conversations.json" -Raw -Encoding UTF8
$data = $raw | ConvertFrom-Json
Write-Host ("Total conversations: " + $data.Count)
Write-Host "---"
for ($i = 0; $i -lt $data.Count; $i++) {
    $conv = $data[$i]
    Write-Host ($i.ToString() + " | " + $conv.name + " | " + $conv.created_at + " | msgs: " + $conv.chat_messages.Count)
}
