Add-Type -AssemblyName System.Drawing

$inputPath = "$PSScriptRoot\public\images\logo.png"
$outputPath = "$PSScriptRoot\public\images\logo-transparent.png"

Write-Host "Processing $inputPath..."

try {
    $img = [System.Drawing.Bitmap]::FromFile($inputPath)
    $newImg = New-Object System.Drawing.Bitmap($img.Width, $img.Height)
    $g = [System.Drawing.Graphics]::FromImage($newImg)
    $g.DrawImage($img, 0, 0, $img.Width, $img.Height)
    
    for ($x = 0; $x -lt $newImg.Width; $x++) {
        for ($y = 0; $y -lt $newImg.Height; $y++) {
            $pixel = $newImg.GetPixel($x, $y)
            # Check for white or near-white
            if ($pixel.R -gt 240 -and $pixel.G -gt 240 -and $pixel.B -gt 240) {
                $newImg.SetPixel($x, $y, [System.Drawing.Color]::Transparent)
            }
        }
    }
    
    $newImg.Save($outputPath, [System.Drawing.Imaging.ImageFormat]::Png)
    Write-Host "Saved to $outputPath"
    
    $img.Dispose()
    $newImg.Dispose()
    $g.Dispose()
} catch {
    Write-Error "Error: $_"
}