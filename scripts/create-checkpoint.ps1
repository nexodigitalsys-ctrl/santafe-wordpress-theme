param(
  [string]$Label = "MANUAL"
)

$ErrorActionPreference = "Stop"

$ProjectRoot = Resolve-Path (Join-Path $PSScriptRoot "..")
$CheckpointRoot = "C:\Users\Administrator\Documents\NEXO DIGITAL\03_ARQUIVO\CHECKPOINTS_SANTAFE"
$Stamp = Get-Date -Format "yyyy-MM-dd_HH-mm-ss"
$SafeLabel = ($Label -replace '[^a-zA-Z0-9_-]', '-').ToUpperInvariant()
$Destination = Join-Path $CheckpointRoot "SANTAFE_SITE_${SafeLabel}_$Stamp"

New-Item -ItemType Directory -Force -Path $Destination | Out-Null

robocopy $ProjectRoot $Destination /E /XD node_modules test-results | Out-Null
$Code = $LASTEXITCODE

@"
Checkpoint: $Destination
Label: $SafeLabel
CreatedAt: $(Get-Date -Format "yyyy-MM-dd HH:mm:ss")
Source: $ProjectRoot
Excluded: node_modules, test-results
"@ | Set-Content -Encoding UTF8 (Join-Path $Destination "CHECKPOINT_INFO.txt")

if ($Code -le 7) {
  Write-Output $Destination
  exit 0
}

exit $Code
