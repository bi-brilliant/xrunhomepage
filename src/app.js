require("dotenv").config();
const PORT = process.env.PORT || 3001;
const express = require("express");
const cors = require("cors");
const https = require("https");
const dbPool = require("./config/db");
const { logger } = require("./logger");

const app = express();

// Middleware
app.use(express.json());
app.use(
  cors({
    origin: [
      "http://localhost:5501",
      "http://127.0.0.1:5501",
      "http://3.1.27.93",
      "https://www.xrun.run/",
    ],
  })
);

// Router
app.get("/cmcData", async (req, res) => {
  try {
    const options = {
      hostname: "pro-api.coinmarketcap.com",
      path: "/v2/cryptocurrency/quotes/latest?CMC_PRO_API_KEY=9b12b985-f906-4084-a942-64fcfa00720f&slug=xrun",
      method: "GET",
    };

    const request = https.request(options, (response) => {
      let data = "";

      response.on("data", (chunk) => {
        data += chunk;
      });

      response.on("end", async () => {
        try {
          const jsonData = JSON.parse(data);
          const {
            status: { timestamp },
            data: {
              19787: {
                id,
                name,
                cmc_rank,
                self_reported_market_cap,
                quote: {
                  USD: {
                    price,
                    volume_24h,
                    volume_change_24h,
                    percent_change_1h,
                    percent_change_24h,
                    percent_change_7d,
                    percent_change_30d,
                    percent_change_60d,
                    percent_change_90d,
                    market_cap_dominance,
                    fully_diluted_market_cap,
                    tvl,
                    last_updated,
                  },
                },
              },
            },
          } = jsonData;

          // Query untuk menyimpan data ke database
          const query = `INSERT INTO cmcdata VALUES (
              NULL,
              '${timestamp}',
              ${id},
              '${name}',
              ${cmc_rank},
              '${price}',
              '${volume_24h}',
              '${volume_change_24h}',
              '${percent_change_1h}',
              '${percent_change_24h}',
              '${percent_change_7d}',
              '${percent_change_30d}',
              '${percent_change_60d}',
              '${percent_change_90d}',
              '${fully_diluted_market_cap}',
              '${market_cap_dominance}',
              '${self_reported_market_cap}',
              NULL,
              '${last_updated}'
            )`;

          // Eksekusi query ke database
          dbPool
            .execute(query)
            .then(() => {
              // Berikan respons JSON setelah eksekusi query berhasil
              res.json({
                timestamp,
                id,
                name,
                cmc_rank,
                price,
                volume_24h,
                volume_change_24h,
                percent_change_1h,
                percent_change_24h,
                percent_change_7d,
                percent_change_30d,
                percent_change_60d,
                percent_change_90d,
                market_cap_dominance,
                fully_diluted_market_cap,
                tvl,
                last_updated,
              });

              logger("cmcData has called: " + timestamp);
              console.log("cmcData has called: ", timestamp);
            })
            .catch((error) => {
              console.error(
                "Kesalahan dalam eksekusi query ke database:",
                error
              );
              res.status(500).json({
                message: "Kesalahan dalam eksekusi query ke database",
              });
            });
        } catch (error) {
          console.error("Kesalahan dalam memproses data:", error);
          res.status(500).json({ message: "Kesalahan dalam memproses data" });
        }
      });
    });

    request.on("error", (error) => {
      console.error("Kesalahan dalam permintaan:", error);
      res.status(500).json({
        message: "Problem while connecting to CoinMarketCap",
        serverMessage: err,
      });
    });

    request.end();
  } catch (error) {
    console.error("Kesalahan dalam permintaan:", error);
    res.status(500).json({ message: "Kesalahan dalam permintaan" });
  }
});

app.listen(PORT, () => {
  console.log("Server start on ", PORT);
});
