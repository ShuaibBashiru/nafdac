<template>
<div :style="opacity">
    <GeneralHeader>
<div class="container-fluid mt-1 p-0">
    <br/>
    <br/>
<div class="row p-0">

    <div class="col-md-5 text-center pt-md-3"> 
        <h1 class="display-4 pt-0 fw-bolder text-center">
           <strong>
            NAFDAC VIRTUAL PORTAL!
           </strong>

        </h1>
        <img src="@/assets/images/chatbot.jpg"  class="float-md-center img-responsive" width="300" alt="">
    </div>

        <div class="col-md-12 text-center"> 
           <button class="btn btn-primary float-end m-2 mt-0 p-2" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@getbootstrap">Get Started</button>
            </div>

</div>
</div>

<!-- Vertically centered scrollable modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><img src="@/assets/images/logo.png" class="img-fluid" alt="" width="40">Agent On Board 24hrs</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
       <div class="row">
                <div class="col-md-12 mb-1">
                    <section v-if="alert!=''">
                <div v-bind:class="'alert '+ classname +' p-2 ps-3 pe-3 m-0 mb-1 mt-1 text-center border-0'"> <span></span> {{alert}} </div>
                </section>
                </div>
        </div>
 <div class="row p-0">
        <div class="col-md-12 mb-3">
            <div class="row">
                <div class="col-md-5"><h4 class="">Hi, {{username}}</h4></div>
                <div class="col-md-7">
                    <div class="input-group">
                        <input type="text" v-model="username" class="form-control" placeholder="Enter your search">
                        <span class="input-group-text">Name</span>
                    </div>
                </div>
                <div class="col-12"> <small class="float-end d-none">{{chatSessionID}}</small></div>
            </div>
        </div>

        <div class="col-md-12">
    <div class="">
    <div class="card bg-light mb-3" style="">
    <div class="card-header">Hi, how can i help you? <span class="float-end"></span></div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12 p-2 mb-0 m-2 rounded">
                  <div class="col-md-10 border p-1 alert-secondary border-0 rounded">
                        Hi, {{username}} I am the Virtual Assistant for Nafdac. I can assist answering your questions.
                        </div>
                <section v-for="(d, index) in currentChat" :key="index">
                    <section v-if="d['attendant_id']==0">
                        <div class="col-md-7 mt-3 border ms-2 p-2 alert-primary border-0 rounded float-start">
                        {{d['message_text']}} <i class="bi-check float-end"></i>
                        </div>
                    </section>
                    <section v-else>
                        <div class="col-md-7 border mt-3 me-4 p-2 alert-info border-0 float-end rounded">
                        {{d['response_text']}}
                        </div>
                    </section>
                </section>
                
            </div>

        </div>

    </div>
    <div class="card-footer">
        
        <form  @submit.prevent="formCheck" role="form" class="">
            <input type="hidden" v-model="token" required>
    <div class="row">
            <div class="col-md-12">
                <span class="float-end" v-if="currentChat.length>0"> <small>You are live....</small>   </span>
                <div class="input-group">
                    <input type="text" v-model="chatMessage" required class="form-control form-control-lg" placeholder="Enter drug name">
            </div>
        </div>
        <div class="col-md-12">
                <button type="submit" class="btn btn-primary float-end border-0 mt-2" :disabled="isDisabled">{{button}}</button>
        </div>
    </div>
        </form>
        </div>

    </div>
    </div>
        </div>

    </div>

        
      </div>
      <div class="modal-footer d-flex justify-content-start">
        <button type="button" class="btn btn-warning float-start" data-bs-dismiss="modal">Close chat</button>
      </div>
    </div>
  </div>
</div>


  </GeneralHeader>
</div>
</template>
<style>

</style>
<script>
import axios from 'axios'
export default {
    data (){
        return{
        auth_check: false,
        usersession: '',
        username: 'User',
        userdata:'',
        applicationMsg: 'Please wait while checking your application status',
        applicationStatus:null,
        token: '',
        isToken: false,
        tryAgain: 'd-none',
        validationClass: 'text-primary',
        validationMsg: 'Please wait while validating and redirecting to the requested page...',
        alert: '',
        alertmodal: '',
        error: '',
        info: [],
        loader: false,
        loadermodal: false,
        classname: '',
        classnamemodal: null,
        isDisabled: false,
        btntxt: 'Ask me',
        button: 'Ask me',
        opacity_enable:'opacity:0.7; pointer-events: none;',
        opacity_disable:'opacity:1; pointer-events:All;',
        opacity:'',
        errormodal: null,
        record:false,
        norecord: '',
        chatMessage: '',
        chatSessionID: '',
        currentChat: '',
    }
    },

   created(){
        this.setStorage()
        this.tokenize()
        this.initiateChatSession()
        },
        methods:{

        initiateChatSession: function(){
            var d = Date.now();
                        this.chatSessionID = parseInt(d)
                },

tokenize: function(){
    this.$Progress.start()
    axios.get(process.env.VUE_APP_API+'/auth/token/tokenize/',{
    params:{
      'token': Math.random(9, 9999)
    }
  }).then(response => {
      if(response.data.status==response.data.statusmsg){
      this.token=response.data.key
      this.isToken=true
      this.tryAgain='d-none'
      axios.defaults.headers.common['X-CSRF-TOKEN'] = response.data.key;
      this.$Progress.finish()
      }else{
      this.$Progress.finish()
      this.isToken=false
      this.tryAgain=''
      this.validationClass = response.data.classname
      this.validationMsg=localStorage.getItem('error')
      } 
    
  }).catch(()=>{
      this.$Progress.fail()
      this.validationClass='text-danger p-2'
      this.validationMsg='Network error! refresh and try again or report this error on our contact page.'
      this.isToken=false
      this.tryAgain=''


  })
  },

            
        setStorage: function(){
        localStorage.setItem('error', this.networkerror)
        },

        formCheck: function(e){
            this.addNew()
    e.preventDefault();
    },
    addNew: function(){
        this.$Progress.start()
        this.isDisabled = true
        // this.opacity = this.opacity_enable
        this.submit='Sending...'
        const form = new FormData();
        form.append('chatMessage', this.chatMessage)
        form.append('userid', this.username)
        form.append('attendant_id', 0)
        form.append('chatSessionID', this.chatSessionID)
        form.append('csrf_test_name', this.token)
        axios.post(process.env.VUE_APP_API+'/form/chat/newchat', form)
        .then(response => {
        if(response.data.status==response.data.statusmsg){
        this.submit=this.submittxt
        this.$Progress.finish()
        this.isDisabled = false
                  this.preview()
            this.replyMessage()
        this.chatMessage=''
        }else{
        this.classname=response.data.classname
        this.alert=response.data.msg
        this.submit=this.submittxt
        this.$Progress.finish()
        this.isDisabled = false

        }
    }).catch(()=>{
        this.classname='alert-danger p-2'
        this.alert=localStorage.getItem('error')
        this.submit=this.submittxt
        this.$Progress.fail()
        this.isDisabled = false
        // this.opacity = this.opacity_disable

    })  
    },

    replyMessage: function(){
        this.$Progress.start()
        this.isDisabled = true
        // this.opacity = this.opacity_enable
        this.submit='Sending...'
        const form = new FormData();
        form.append('chatMessage', this.chatMessage)
        form.append('userid', this.username)
        form.append('attendant_id', 0)
        form.append('chatSessionID', this.chatSessionID)
        form.append('csrf_test_name', this.token)
        axios.post(process.env.VUE_APP_API+'/form/chat/replychat', form)
        .then(response => {
        if(response.data.status==response.data.statusmsg){
        this.submit=this.submittxt
        this.$Progress.finish()
        this.isDisabled = false
        this.preview()
        this.chatMessage=''
        }else{
        this.classname=response.data.classname
        this.alert=response.data.msg
        this.submit=this.submittxt
        this.$Progress.finish()
        this.isDisabled = false
        // this.opacity = this.opacity_disable

        }
    }).catch(()=>{
        this.classname='alert-danger p-2'
        this.alert=localStorage.getItem('error')
        this.submit=this.submittxt
        this.$Progress.fail()
        this.isDisabled = false
        // this.opacity = this.opacity_disable

    })  
    },

 preview: function(){
        this.$Progress.start()
        axios.get(process.env.VUE_APP_API+'/api/chats/currentchat/',{
              params:{
                userid: this.username,
                chatSessionID: this.chatSessionID
            }
        })
        .then(response => {
            if(response.data.status == response.data.statusmsg){
            this.currentChat = response.data.result
            this.$Progress.finish()
            }else{
            this.alert = response.data.msg
            this.classname = response.data.classname
            this.$Progress.finish()
            }
        
        }).catch(()=>{
            this.classname='alert-danger p-2'
            this.alert=localStorage.getItem('error')
            this.$Progress.fail()

        })
    },

    },


    }
</script>