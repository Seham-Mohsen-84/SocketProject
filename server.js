import express from 'express';
import { createServer } from 'http';
import { Server } from 'socket.io';
import Redis from 'ioredis';

const app = express();
const httpServer = createServer(app);

const io = new Server(httpServer, {
    cors: {
        origin: "*",
    }
});

const redis = new Redis({
    host: '127.0.0.1',
    port: 6379,
});

const channelName = 'laravel-database-notification';

redis.subscribe(channelName, (err, count) => {
    if (err) {
        console.error(`Error subscribing to channel:`, err);
        return;
    }
    console.log(`Subscribed to "${channelName}". Total subscriptions: ${count}`);
});

redis.on('message', (channel, message) => {
    console.log(`Received message from Redis channel "${channel}":`, message);
    try {
        const parsed = JSON.parse(message);
        io.emit(parsed.event, parsed.data);
    } catch (e) {
        console.error('Error parsing message from Redis:', e);
    }
});

io.on('connection', (socket) => {
    console.log('A user connected:', socket.id);
    
    socket.on('disconnect', () => {
        console.log('A user disconnected:', socket.id);
    });
});

httpServer.listen(3000, () => {
    console.log('Socket.io server is running on port 3000');
});