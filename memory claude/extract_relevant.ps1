$raw = Get-Content "c:\laragon\laravel\e-recruitment\memory claude\conversations.json" -Raw -Encoding UTF8
$data = $raw | ConvertFrom-Json

# Conversations yang relevan dengan e-recruitment
$indices = @(2, 5, 14, 19, 20, 25, 33)

foreach ($idx in $indices) {
    $conv = $data[$idx]
    Write-Host "============================================"
    Write-Host ("INDEX: " + $idx)
    Write-Host ("JUDUL: " + $conv.name)
    Write-Host ("TANGGAL: " + $conv.created_at)
    Write-Host ("TOTAL PESAN: " + $conv.chat_messages.Count)
    Write-Host "--------------------------------------------"
    
    foreach ($msg in $conv.chat_messages) {
        $role = $msg.sender
        $text = ""
        
        if ($msg.text) {
            $text = $msg.text
        } elseif ($msg.content) {
            foreach ($c in $msg.content) {
                if ($c.type -eq "text") {
                    $text += $c.text
                }
            }
        }
        
        if ($text.Length -gt 0) {
            Write-Host ""
            Write-Host ("[$role]:")
            Write-Host ($text.Substring(0, [Math]::Min(2000, $text.Length)))
            Write-Host "---"
        }
    }
    Write-Host ""
}
