// var filter = 'win16|win32|win64|mac'

// if (navigator.platform) {
//   if (0 > filter.indexOf(navigator.platform.toLowerCase())) {
//     location.href = '/m'
//   }
// }

function detectMobileDevice(agent) {
  const mobileRegex = [
    /Android/i,
    /iPhone/i,
    /iPad/i,
    /iPod/i,
    /BlackBerry/i,
    /Windows Phone/i
  ]

  return mobileRegex.some(mobile => agent.match(mobile))
}
// alert(detectMobileDevice(window.navigator.userAgent))
const isMobile = detectMobileDevice(window.navigator.userAgent)

if (isMobile || window.innerWidth <= 768) {
  location.href = '/m'
}