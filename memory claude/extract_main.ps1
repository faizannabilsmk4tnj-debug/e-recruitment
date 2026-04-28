$raw = Get-Content "c:\laragon\laravel\e-recruitment\memory claude\conversations.json" -Raw -Encoding UTF8
$data = $raw | ConvertFrom-Json

# Percakapan utama: index 14 (585 msgs) dan 25 (314 msgs)
$indices = @(14, 25)

foreach ($idx in $indices) {
    $conv = $data[$idx]
    $outFile = "c:\laragon\laravel\e-recruitment\memory claude\conv_$idx.txt"
    
    $lines = @()
    $lines += "============================================"
    $lines += "INDEX: $idx"
    $lines += "JUDUL: " + $conv.name
    $lines += "TANGGAL: " + $conv.created_at
    $lines += "TOTAL PESAN: " + $conv.chat_messages.Count
    $lines += "--------------------------------------------"
    
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
            $lines += ""
            $lines += "[$role]:"
            # Ambil 3000 karakter per pesan
            $lines += $text.Substring(0, [Math]::Min(3000, $text.Length))
            $lines += "---MSG_END---"
        }
    }
    
    $lines | Out-File $outFile -Encoding UTF8
    Write-Host "Selesai: conv_$idx.txt"
}
