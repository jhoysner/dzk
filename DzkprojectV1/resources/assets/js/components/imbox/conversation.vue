  <template>
      <div>

          <div class="col-md-12 offset-2">
           <div class="mesgs">
                <div class="msg_history">
                  <template v-for="message in messages">
                    <div v-if="UserReceive(message)" class="incoming_msg mb-2">
                      <div  class="incoming_msg_img">
                        <img src="https://ptetutorials.com/images/user-profile.png" alt="sunil">
                      </div>
                      <div class="received_msg" >
                        <div class="received_withd_msg">
                          <p>{{message.message}}</p>
                          <span class="time_date"> {{formatDate(message.created_at)}}</span>
                        </div>
                      </div>
                    </div>
                    <div v-if="UserSend(message)"  class="outgoing_msg">
                      <div class="sent_msg">
                        <p>{{message.message}}</p>
                        <span class="time_date"> {{formatDate(message.created_at)}}</span>
                      </div>
                    </div>
                
                  </template>
                </div>
                <div class="type_msg">
                  <div class="input_msg_write">
                    <input type="text"  v-model="form.message" class="write_msg" placeholder="Type a message" />
                    <button class="msg_send_btn"  @click="send" type="button"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        
      </div>

  </template>

  <script>
  import Bus from '../../utilities/EventBus';
  import moment from 'moment';
  moment.locale('es');

      export default {
      props:['id'],
      data() {
          return {
              messages: [],
              form: {
                users_id_from: '',
                subject: '',
                message: '',
                thread: '',
                commerce_idcommerce: '',
                messengerservicetopic_idmessengerservicetopic: '1',
              },  
              commerce: {},
              user:{}
          }
      },
      created(){
          this.findThread()
          this.auth()

      },
        
      methods: {
          auth() {
            axios.get('/api/profile').then((response) => {
              console.log(response)
              this.form.users_id_from = response.data.user.id;
              this.user = response.data.user;
              // this.index();
            })
            .catch(err => console.log(err))
          },
          findThread(){
             axios.get('/api/find-thread/'+this.id).then(response => {  
              // console.log(response)      
              this.messages = response.data.data
              this.form.commerce_idcommerce = response.data.data[0].commerce_idcommerce
              this.form.thread = response.data.data[0].thread
              this.form.subject = response.data.data[0].subject
              // this.form.users_id_to = response.data.data[0].users_id_from
           
            })
            .catch(err => console.log(err))
          },
          send(){
            axios.post('/api/message-send', this.form).then(response => {
              this.form.message = ''
              this.findThread()
              Bus.$emit('header-message-send') 
            })
            .catch(err => console.log(err));
          },
          formatDate(value){
              return  moment(value).format('LT a | MMMM D');
          },     
          UserReceive: function (message) {
            return message.users_id_from != this.user.id
          },          
          UserSend: function (message) {
            return message.users_id_from == this.user.id
          },

      },
      watch:{
          id: function() { // watch it
            this.findThread();
          }
      }, 


      }
  </script>
  <style>
  #section-mailbox: {
   margin-top: 100px;
  }


  img{ max-width:100%;}

  .incoming_msg_img {
    display: inline-block;
    width: 6%;
  }
  .received_msg {
    display: inline-block;
    padding: 0 0 0 10px;
    vertical-align: top;
    width: 92%;
   }
   .received_withd_msg p {
    background: #ebebeb none repeat scroll 0 0;
    border-radius: 3px;
    color: #646464;
    font-size: 14px;
    margin: 0;
    padding: 5px 10px 5px 12px;
    width: 100%;
  }
  .time_date {
    color: #747474;
    display: block;
    font-size: 12px;
    margin: 0 0 0;
  }
  .received_withd_msg { width: 57%;}
  .mesgs {
    float: left;
    padding: 30px 15px 0 25px;
    width: 60%;
  }

   .sent_msg p {
    background: #05728f none repeat scroll 0 0;
    border-radius: 3px;
    font-size: 14px;
    margin: 0; color:#fff;
    padding: 5px 10px 5px 12px;
    width:100%;
  }
  .outgoing_msg{ overflow:hidden; margin:26px 0 26px;}
  .sent_msg {
    float: right;
    width: 46%;
  }
  .input_msg_write input {
    background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
    border: medium none;
    color: #4c4c4c;
    font-size: 15px;
    min-height: 48px;
    width: 100%;
  }

  .type_msg {border-top: 1px solid #c4c4c4;position: relative;}
  .msg_send_btn {
    background: #05728f none repeat scroll 0 0;
    border: medium none;
    border-radius: 50%;
    color: #fff;
    cursor: pointer;
    font-size: 17px;
    height: 33px;
    position: absolute;
    right: 0;
    top: 11px;
    width: 33px;
  }
  .messaging { padding: 0 0 50px 0;}
  .msg_history {
    height: 516px;
    overflow-y: auto;
  }
  </style>
