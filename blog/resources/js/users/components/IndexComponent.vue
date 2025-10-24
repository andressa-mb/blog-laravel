<template>
    <div class="container">
        <div>
            <button class="btn btn-info mx-2" v-if="users.links" @click="loadUsers(users.links.first)">1</button>
            <button class="btn btn-primary mx-2" v-if="users.links && users.links.prev != null" @click="loadUsers(users.links.prev)">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z"/>
                    <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z"/>
                </svg>
            </button>

            <button class="btn btn-secondary border rounded border-dark border-top-0 text-center mx-2" v-if="users.meta" disabled>{{users.meta.current_page}}</button>

            <button class="btn btn-primary mx-2" v-if="users.links && users.links.next != null" @click="loadUsers(users.links.next)">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
                    <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                </svg>
            </button>
            <button class="btn btn-info mx-2" v-if="users.links" @click="loadUsers(users.links.last)">{{users.meta.last_page}}</button>
        </div>

        <!-- MODAIS EDIT E DELETE -->
        <EditUser :isEdit="modalIsEdit" :userId="selectedUser.id" @closeMod="closeModal" v-if="selectedUser && modalShow"/>
        <div class="d-flex flex-wrap justify-content-around">
            <div class="card m-2" style="width: 18rem;" v-for="(user, index) in users.data" :key="index">
                <img src="#" class="card-img-top" alt="imgUser">
                <div class="card-body">
                    <h5 class="card-title">{{user.name}}</h5>
                    <ul class="card-text">
                        <li><strong>E-mail:</strong> {{user.email}}</li>
                        <li><strong>Idioma:</strong> {{user.lang}}</li>
                        <li v-for="role in user.roles" :key="role.id">
                            <strong>Perfil:</strong> {{role.name}}
                        </li>
                    </ul>
                </div>
                <div class="card-footer d-flex justify-content-around">
                    <a href="javascript:void(0)" @click="editUser(user)" class="btn btn-warning">Editar</a>
                    <a href="#" class="btn btn-danger">Excluir</a>
                </div>
            </div>
        </div>

        <div>
            <button class="btn btn-info mx-2" v-if="users.links" @click="loadUsers(users.links.first)">1</button>
            <button class="btn btn-primary mx-2" v-if="users.links && users.links.prev != null" @click="loadUsers(users.links.prev)">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z"/>
                    <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z"/>
                </svg>
            </button>

            <button class="btn btn-secondary border rounded border-dark border-top-0 text-center mx-2" v-if="users.meta" disabled>{{users.meta.current_page}}</button>

            <button class="btn btn-primary mx-2" v-if="users.links && users.links.next != null" @click="loadUsers(users.links.next)">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
                    <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                </svg>
            </button>
            <button class="btn btn-info mx-2" v-if="users.links" @click="loadUsers(users.links.last)">{{users.meta.last_page}}</button>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import EditUser from './modals/user/EditUser.vue';

const route = useRoute();
const users = ref({});
const modalIsEdit = ref(false);
const modalShow = ref(false);
const selectedUser = ref({});

function closeModal(){
    loadUsers('api/users');
    modalShow.value = false;
    selectedUser.value = {};
}

async function loadUsers(url){
    axios.get(url).then(({data}) => {
        users.value = data;
    }).catch(error => {
        console.log(error);
    });
}

function editUser(user){
    try{
        selectedUser.value = user;
        modalIsEdit.value = true;
        modalShow.value = true;
    }catch(error){
        console.error('Erro ao carregar usuário:', error);
    }
}

onMounted(() => {
    console.log('index montado');
    loadUsers('api/users');
});
</script>
