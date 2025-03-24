const express = require('express');
const app = express();
const bodyParser = require('body-parser');
const connectDB = require('./db');
const routes = require('./routes');

// Conectar a MongoDB
connectDB();

app.use(bodyParser.json());

app.use(express.json({ 
  limit: '20mb', // Aumentar a 20MB para cubrir el Base64
  verify: (req, res, buf) => {
      req.rawBody = buf.toString();
  }
}));

app.use(express.urlencoded({ 
  extended: true, 
  limit: '20mb' 
}));

// Configurar CORS (igual que antes)
app.use((req, res, next) => {
  res.setHeader('Access-Control-Allow-Origin', '*');
  res.setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE');
  res.setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization');
  next();
});


// Rutas
app.use('/api', routes);

const PORT = process.env.PORT || 3001;
app.listen(PORT, () => {
  console.log(`Servidor API en el puerto ${PORT}`);
});
