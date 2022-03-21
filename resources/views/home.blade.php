@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header" id="test">users</div>

                <div class="card-body p-0">
                   @foreach($users as $user)
                   
                    <div class="li list-item person   p-2 " id="{{$user->id}}" onclick="show_person_chat({{$user->id}})">{{$user->name}} 
                        @if($user->status == "online")
                        
                            <span class="badge bg-success badge-primary">0</span>
                        @else
                        <span class="badge bg-secondary badge-primary">0</span>

                        @endif  
                    </div>
                  @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-8">
        <div class="container  ">
        <div class="row">
            <div class="parent_chat d-none" id="parent_chat">
                <div class="authID" id="{{auth()->id()}}"></div>
                <div class="chat-content"  >
                    <ul class="list-group list_messages"></ul>
                </div>
                <div class="chat-section">
                    <div class="chat-box ">
                        <div class="chat-input text-white bg-secondary p-3 mt-1 chatInput" id="0" contenteditable=""></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.socket.io/4.4.1/socket.io.min.js" integrity="sha384-fKnu0iswBIqkjxrhQCTZ7qlLHOFEgNkRmK2vaO/LbTZSXdJfAu6ewRBdwHPhBo/H" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
 
           
       <script>
           
          function show_person_chat(id){
             
            document.getElementsByClassName("list_messages")[0].innerHTML="";
            document.getElementsByClassName("chatInput")[0].id=id;
            document.getElementById("parent_chat").classList.remove("d-none");
            var data = {
                        "another_side":  id
                    };
            $.ajax({ 
                       method: "GET",
                       url: 'http://localhost:8000/getChatOfToPersons',
                       data: data,
                       success: function(response) {
                           
                          
                         for (let i=0;i<response.length;i++)
                         {
                            if(id ==response[i].reciver_id)
                            {
                                $('.chat-content ul').append('<li class="list-group-item active">me : '+response[i].content+'</li>'); 
                            }
                            else   
                            {
                                $('.chat-content ul').append('<li class="list-group-item active">him : '+response[i].content+'</li>'); 

                            }                          
                         }
                     
                       },
                       error:function(e){
                           console.log(e)
                       }
                   })
            }
            
           $(function(){
           
            //declare socket
            let IP_SERVER='127.0.0.1';
            let SOCKET_PORT='3000';
            let SOCKET=io(IP_SERVER+':'+SOCKET_PORT);
            SOCKET.on('connection')

           

            //grt current user
            let AUTHID=$('.authID').attr('id');
////////////////////////////////
            function render_online_users(id)
            {
               // console.log("make one on");
                 $('.person#'+id).children().addClass('bg-success').removeClass('bg-secondary');
                  
            }
            //declere iam online
            SOCKET.emit('onlineUser',AUTHID);
            //recive online users
            SOCKET.on('iamOnline',(user)=>
            {
                 //console.log("user is on => "+user);
                    render_online_users(user);
            });
            
////////////////////////////////
            function render_offline_users(id)
            {
               // console.log("make one off");
                 $('.person#'+id).children().addClass('bg-secondary').removeClass('bg-success');
                  
            }
            $('.log_out').submit(function(){
                SOCKET.emit('offlineUser',AUTHID);
            });
            //recive offline users
            SOCKET.on('iamOffline',(user)=>
            {
                  //console.log("user is off => "+user);
                    render_offline_users(user);
            });
////////////////////////////////
            let chatInput=$('.chatInput')
            
            chatInput.keypress(function(e){
         

                let message=$(this).html();
               // console.log(message);
                if(e.which===13 && !e.shiftkey)
                {
                    let reciver_id=chatInput.attr("id");
                    let message_info={
                        "reciver":reciver_id,
                        "content":message,
                        "sender_id":AUTHID   
                    }
                    SOCKET.emit('sendMessage',message_info);
                    $('.chat-content ul').append('<li class="list-group-item active">me : '+message+'</li>'); 
                    chatInput.html(''); 
                    
                    var data = {  
                        "_token": "{{ csrf_token() }}",
                        "content" : message,
                        "reciver_id":  reciver_id
                        
                    };
                    
                    $.ajax({
                       
                         
                        method: "POST",
                        url: 'http://localhost:8000/message',
                        data: data,
                        success: function() {
                       //console.log("message sended")
                        },
                        error:function(e){
                            console.log(e)
                        }
                    })
                    return false;
                }
            })
            
            
            SOCKET.on('sendToChatBox',(message)=>{
                let id_chatInput=$('.chatInput').attr("id");
               // console.log(message);
                //console.log("idchat="+id_chatInput);
                //console.log("sender=:"+message.sender_id);
               if(message.reciver==AUTHID &&  message.sender_id==id_chatInput)
                {
                    $('.chat-content ul').append('<li class="list-group-item active float-right ">him : '+message.content+'</li>');
   

                }  
                else
                {

                } 
            });
                 
           });
          
       </script>
      
        </div>
    </div>
</div>
@endsection
