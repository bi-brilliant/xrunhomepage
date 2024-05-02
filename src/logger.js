const fs = require("fs");
const path = require("path");

// Fungsi untuk menulis log ke file
function logger(logText) {
  const logFilePath = path.join(__dirname, "logs", getCurrentLogFileName());
  const formattedLog = `[${new Date().toLocaleString()}] ${logText}\n`;

  fs.appendFileSync(logFilePath, formattedLog, { encoding: "utf8" });
}

// Fungsi untuk mendapatkan nama file log saat ini
function getCurrentLogFileName() {
  const today = new Date();
  const year = today.getFullYear();
  const month = String(today.getMonth() + 1).padStart(2, "0");
  const day = String(today.getDate()).padStart(2, "0");
  return `${day}-${month}-${year}.log`;
}

module.exports = { logger };
