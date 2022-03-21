const express=require('express');
const { Socket } = require('socket.io');
const app=express();

const server=require('http').createServer(app) ;
const io=require('socket.io')(server,{
  cors: {origin:"*"}
}); 

io.sockets.on('connection',(socket)=>{
console.log("connection started");

    socket.on('sendMessage',(message)=>{ 
        //io.sockets.emit('sendToChatBox',message);     
        socket.broadcast.emit('sendToChatBox',message); 
    }); 
    socket.on('onlineUser',(user)=>{
        socket.broadcast.emit('iamOnline',user);  
    });
    socket.on('offlineUser',(user)=>{
        socket.broadcast.emit('iamOffline',user);  
    });
    
});

server.listen(3000,()=>{
    console.log("good")
});