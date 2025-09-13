const http = require('http');
const url = require('url');

const hostname = 'localhost';
const port = 8000;

const server = http.createServer((req, res) => {
  const reqUrl = url.parse(req.url, true);

  // Set default min and max delay in seconds
  const minDelay = parseFloat(reqUrl.query.min_delay) || 0.01;
  const maxDelay = parseFloat(reqUrl.query.max_delay) || 0.1;

  // Generate a random delay
  const delay = Math.random() * (maxDelay - minDelay) + minDelay;

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
