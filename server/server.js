const http = require('http');
const url = require('url');

const hostname = 'localhost';
const port = 8000;

const server = http.createServer((req, res) => {
  const reqUrl = url.parse(req.url, true);

  // Get specified delay in seconds, default to 0.1 seconds if not provided
  const delay = parseFloat(reqUrl.query.delay) || 0.1;

  setTimeout(() => {
    res.statusCode = 200;
    res.setHeader('Content-Type', 'application/json');
    res.end(JSON.stringify({
      status: 'success',
      message: `Response after ${delay.toFixed(3)} seconds`,
      delay_seconds: delay,
      timestamp: new Date().toISOString()
    }));
  }, delay * 1000); // Convert seconds to milliseconds
});

server.listen(port, hostname, () => {
  console.log(`Server running at http://${hostname}:${port}/`);
});