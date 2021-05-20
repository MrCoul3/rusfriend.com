<template>
  <section id="vue-my-students" class="my-students admin-inner admin-panel-section ">
    <h2 class="main-title">Мои студенты</h2>

    <div class="my-students-header">
      <div class="wrap">
        <p class="name">Имя</p>
        <p class="contacts-data">Контактные данные </p>
        <p class="status">Статус</p>
        <p class="actions">Действия</p>
      </div>
    </div>

    <div class="decor-line"></div>
    <div class="my-students-content">
      <div v-for="arr in array" :data-name="arr.name" class="student">
        <div class="wrap">
          <div class="student__elem student__elem--name">
            <img v-if="arr.avatar" :src="arr.avatar" class="student-name-icon">
            <img v-else src="../images/icons/user-ico.svg" class="student-name-icon">
            <div class="student-name-name">{{ arr.name }}</div>
          </div>

          <div class="student__elem student__elem--contacts">
            <div class="student-contacts-email"><span>email: </span>{{ arr.email }}</div>
            <div class="student-contacts-skype"><span>skype: </span>{{ arr.skype }}</div>
          </div>
          <div :class="arr.status" :status="arr.status" class="student__elem student__elem--status">
            {{ arr.status }}
          </div>
          <div class="student__elem student__elem--actions">
            <!--                        <div class="student-actions-invite">отправить приглашение на урок</div>-->
<!--            <div class="student-actions-message">написать сообщение</div>-->
            <div :status="arr.status" :email="arr.email" @click="blockUser($event)"
                 class="student-actions-ban">{{ arr.text }}
            </div>
          </div>
        </div>
        <div class="decor-line"></div>
      </div>
    </div>
  </section>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      array: [],
      statusColor: '',
      avatarOpened: null,
      avatarCloseBtn: null,
    }
  },
  mounted: function () {
    this.getAllUsersInfo();
  },
  methods: {
    getAllUsersInfo: function () {
      axios.post('/handle.php', JSON.stringify({'method': 'getAllUsersInfo'}))
          .then((response) => {
            // // console.log(response.data)
            localStorage.setItem('getAllUsersInfo', JSON.stringify(response.data))
            let data = response.data;
            let array = this.array;
            data.forEach(function (val, k) {
              // // console.log(val.status)
              if (val.status !== 'admin') {
                array.push(val);
              }
              if (val.status === 'active' || val.status === 'new') {
                val.text = 'заблокировать';
              }
              if (val.status === 'blocked') {
                val.text = 'разблокировать';
              }
            })
            // // console.log(array)
          });
    },
    openAvatar() {
      if (this.avatarOpened === null) {
        this.avatarOpened = 'user-avatar-opened';
        this.avatarCloseBtn = 'close-btn-active';
      } else {
        this.avatarOpened = null;
        this.avatarCloseBtn = null;
      }
    },
    blockUser(event) {
      // // console.log(event.target.parentNode.previousElementSibling);
      let statusElem = event.target.parentNode.previousElementSibling;
      let email = event.target.getAttribute('email');
      let status = event.target.getAttribute('status');
      let method = null;
      if (status === 'active' || status === 'new') {
        method = 'blockUser';
        this.statusColor = 'status-blocked';
      } else {
        method = 'unBlockUser';
        this.statusColor = '';
      }
      let data = {
        email: email,
        'method': method,
      }
      axios.post('/handle.php', JSON.stringify(data))
          .then((response) => {
            // // console.log(response.data)
            let data = response.data;
            event.target.setAttribute('status', data);
            statusElem.innerHTML = data;
            statusElem.setAttribute('status', data);
            if (data === 'blocked') {
              event.target.innerHTML = 'разблокировать';
              statusElem.classList.add('blocked');
            } else {
              event.target.innerHTML = 'заблокировать';
              statusElem.classList.remove('blocked');
            }
          });
    },
  },
}

</script>

<style scoped>

</style>