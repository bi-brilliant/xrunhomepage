// const WebSocket = require("ws");
// const mysql = require("mysql");

// // Konfigurasi koneksi database
// const db = mysql.createConnection({
//   host: "localhost:3307",
//   user: "root", // Ganti dengan username MySQL Anda
//   password: "", // Ganti dengan password MySQL Anda
//   database: "tempxscan",
// });

// // Buat koneksi ke database
// db.connect((err) => {
//   if (err) {
//     console.error("Kesalahan koneksi database:", err);
//     return;
//   }
//   console.log("Terhubung ke database MySQL");
// });

// // Buat server WebSocket
// const wss = new WebSocket.Server({ port: 8080 }); // Ganti dengan port yang Anda inginkan

// // Event handler ketika ada klien terhubung ke WebSocket
// wss.on("connection", (ws) => {
//   console.log("Klien terhubung");

//   // Query awal untuk mendapatkan data dengan id=26
//   db.query("SELECT * FROM cmcdata WHERE id = 26", (err, results) => {
//     if (err) {
//       console.error("Kesalahan dalam permintaan database:", err);
//       return;
//     }

//     // Kirim data awal ke klien
//     ws.send(JSON.stringify(results[0]));
//   });

//   // Event handler ketika ada pesan dari klien
//   ws.on("message", (message) => {
//     console.log(`Pesan dari klien: ${message}`);
//   });
// });

// // Event handler ketika server WebSocket mendengarkan
// wss.on("listening", () => {
//   console.log("Server WebSocket mendengarkan pada port 8080");
// });

// // Event handler ketika ada kesalahan pada server WebSocket
// wss.on("error", (err) => {
//   console.error("Kesalahan pada server WebSocket:", err);
// });

// Kode diatas untuk web socket PHP CoinMarket Cap Listener

import fetch from "node-fetch";
import WebSocket from "ws";

const wss = new WebSocket.Server({ port: 8080 });

wss.on("connection", (ws) => {
  console.log("Klien terhubung");

  // Logika berlangganan ke CoinMarketCap API di sini
  // Gunakan setInterval atau teknik berlangganan API real-time sesuai kebutuhan

  // Misalnya, berlangganan data setiap 10 detik
  const subscriptionInterval = setInterval(async () => {
    try {
      const response = await fetch(
        "https://pro-api.coinmarketcap.com/v2/cryptocurrency/quotes/latest?CMC_PRO_API_KEY=9b12b985-f906-4084-a942-64fcfa00720f&slug=xrun"
      );
      const data = await response.json();

      console.log(JSON.stringify(data));

      // Kirim data ke klien melalui WebSocket
      ws.send(JSON.stringify(data));
    } catch (error) {
      console.error("Kesalahan saat mengambil data dari CoinMarketCap:", error);
    }
  }, 10000); // Setiap 10 detik

  // Event handler ketika klien menutup koneksi
  ws.on("close", () => {
    console.log("Klien terputus");
    // Hentikan berlangganan jika diperlukan
    clearInterval(subscriptionInterval);
  });
});

console.log("WebSocket server mendengarkan pada port 8080");
