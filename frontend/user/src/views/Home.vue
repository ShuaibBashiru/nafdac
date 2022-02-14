<template>
<div :style="opacity">
    <GeneralHeader>
<div class="container-fluid mt-1 p-0">
    <br/>
    <br/>
<div class="row p-0 mt-2">

    <div class="col-md-3 text-center pt-md-3 mt-2"> 
        <img src="@/assets/images/logo.png"  class="float-md-end mt-md-5 img-responsive" width="250" alt="">
    </div>
        <div class="col-md-6">
                <h1 class="display-4 pt-0 fw-bolder text-center">
           <strong>
             NAFDAC PORTAL!
           </strong>
        </h1>
            <p class="lead mt-2 p-5 text-center text-muted">We are responsible for regulating and controlling manufacture. Offer everyone ease of access 24hrs</p>
    </div>

    <div class="col-md-3 mt-2 text-center">
         <a href="/app/site/chatbot"> <img src="@/assets/images/chatbot.jpg" class="float-md-start mt-md-5 img-responsive" width="300" alt=""></a>

    </div>
        <div class="col-md-12 text-center"> 
            <a href="/app/site/chatbot"><button class="btn btn-primary m-2 mt-0 p-2">Virtual agent</button> </a>
            <a href="/app/site/productverify"><button class="btn btn-outline-primary m-2 mt-0 p-2">Product verification</button> </a>
            <a href="/app/site/companyverify"><button class="btn btn-primary m-2 mt-0 p-2">Company verification</button> </a>
            </div>

</div>
</div>
  </GeneralHeader>
</div>
</template>
<style>

</style>
<script>

// import axios from 'axios'
export default {
    data (){
        return{
        alert: '',
        classname: '',
        record:false,
        norecord: '',
        toggle:null,
        opacity_enable:'opacity:0.7; pointer-events: none;',
        opacity_disable:'opacity:1; pointer-events:All;',
        opacity:'',
    }
    },

    created(){
    }, 
    methods:{
    },


    }
</script>