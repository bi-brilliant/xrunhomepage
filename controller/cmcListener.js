const WebSocket = require("ws");
const mysql = require("mysql");

// Konfigurasi koneksi database
const db = mysql.createConnection({
  host: "localhost:3307",
  user: "root", // Ganti dengan username MySQL Anda
  password: "", // Ganti dengan password MySQL Anda
  database: "tempxrun",
});

// Buat koneksi ke database
db.connect((err) => {
  if (err) {
    console.error("Kesalahan koneksi database:", err);
    return;
  }
  console.log("Terhubung ke database MySQL");
});

// Buat server WebSocket
const wss = new WebSocket.Server({ port: 8080 }); // Ganti dengan port yang Anda inginkan

// Event handler ketika ada klien terhubung ke WebSocket
wss.on("connection", (ws) => {
  console.log("Klien terhubung");

  // Query awal untuk mendapatkan data dengan id=26
  db.query("SELECT * FROM cmcdata WHERE id = 26", (err, results) => {
    if (err) {
      console.error("Kesalahan dalam permintaan database:", err);
      return;
    }

    // Kirim data awal ke klien
    ws.send(JSON.stringify(results[0]));
  });

  // Event handler ketika ada pesan dari klien
  ws.on("message", (message) => {
    console.log(`Pesan dari klien: ${message}`);
  });
});

// Event handler ketika server WebSocket mendengarkan
wss.on("listening", () => {
  console.log("Server WebSocket mendengarkan pada port 8080");
});

// Event handler ketika ada kesalahan pada server WebSocket
wss.on("error", (err) => {
  console.error("Kesalahan pada server WebSocket:", err);
});
