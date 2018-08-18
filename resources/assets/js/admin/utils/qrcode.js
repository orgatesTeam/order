export function getQRCode(toURL, width = 360, height = 360) {
    return `http://chart.apis.google.com/chart?cht=qr&chl="${toURL}"&chs=${width}x${height}`
}
