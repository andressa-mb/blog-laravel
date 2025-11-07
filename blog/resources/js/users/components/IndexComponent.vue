<template>
    <div class="container">
        <!-- BARRA DE PESQUISA -->
        <form class="form-inline my-3 border border-dark p-3 w-50 shadow p-3 mb-5 bg-white rounded d-flex align-items-center flex-wrap gap-3">
            <div class="form-group d-flex align-items-center gap-2">
                <label for="profile">Perfil</label>
                <select id="profile" class="form-control" name="profile" v-model="profile">
                    <option value="">Todos</option>
                    <option v-for="role in listRoles" :key="role.id" :value="role.id">{{role.name}}</option>
                </select>
            </div>
            <div class="form-group d-flex align-items-center gap-2">
                <label for="name">Nome:</label>
                <input class="form-control mr-sm-2" id="name" type="search" placeholder="Sabrina" name="search" aria-label="Search" v-model="search">
            </div>
        </form>

        <div v-if="msgError !== ''">
            <p class="font-weight-normal text-center">{{msgError}}</p>
        </div>

        <!-- PAGINAÇÃO -->
        <div>
            <button class="btn btn-info mx-2" v-if="users.links" @click="loadUsers(users.links.first)">1</button>
            <button class="btn btn-primary mx-2" v-if="users.links && users.links.prev != null" @click="loadUsers(users.links.prev)">
                <i class="bi bi-box-arrow-left"></i>
            </button>

            <button class="btn btn-secondary border rounded border-dark border-top-0 text-center mx-2" v-if="users.meta" disabled>{{users.meta.current_page}}</button>

            <button class="btn btn-primary mx-2" v-if="users.links && users.links.next != null" @click="loadUsers(users.links.next)">
                <i class="bi bi-box-arrow-right"></i>
            </button>
            <button class="btn btn-info mx-2" v-if="users.links" @click="loadUsers(users.links.last)">{{users.meta.last_page}}</button>
        </div>

        <!-- MODAIS EDIT E DELETE -->
        <ActionUser :isEdit="modalIsEdit" :userId="selectedUser.id" @closeMod="closeModal" v-if="selectedUser && modalShow"/>
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
                    <button v-on:click="deleteUser(user)" class="btn btn-danger">Excluir</button>
                </div>
            </div>
        </div>

        <!-- PAGINAÇÃO -->
        <div>
            <button class="btn btn-info mx-2" v-if="users.links" @click="loadUsers(users.links.first)">1</button>
            <button class="btn btn-primary mx-2" v-if="users.links && users.links.prev != null" @click="loadUsers(users.links.prev)">
                <i class="bi bi-box-arrow-left"></i>
            </button>

            <button class="btn btn-secondary border rounded border-dark border-top-0 text-center mx-2" v-if="users.meta" disabled>{{users.meta.current_page}}</button>

            <button class="btn btn-primary mx-2" v-if="users.links && users.links.next != null" @click="loadUsers(users.links.next)">
                <i class="bi bi-box-arrow-right"></i>
            </button>
            <button class="btn btn-info mx-2" v-if="users.links" @click="loadUsers(users.links.last)">{{users.meta.last_page}}</button>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';
import { useRoute } from 'vue-router';
import ActionUser from './modals/user/ActionUser.vue';

const route = useRoute();
const users = ref({});
const modalIsEdit = ref(false);
const modalShow = ref(false);
const selectedUser = ref({});
const msgError = ref('');
const listRoles = ref({});
const search = ref('');
const profile = ref('');

function closeModal(){
    loadUsers('api/users');
    modalShow.value = false;
    selectedUser.value = {};
}

async function loadUsers(url, search = '', profile = ''){
    axios.get(url, {
        params: {search, profile}
    }).then(({data}) => {
        users.value = data;
    }).catch(error => {
        msgError.value = `Usuário não autorizado. ${error}.`
        console.log(error);
    });
}

function editUser(user){
    try{
        selectedUser.value = user;
        modalIsEdit.value = true;
        modalShow.value = true;
    }catch(error){
        msgError.value = `Usuário não autorizado. ${error}.`
        console.error('Erro ao carregar usuário:', error);
    }
}

function deleteUser(user){
    try{
        selectedUser.value = user;
        modalIsEdit.value = false;
        modalShow.value = true;
    }catch(error){
        msgError.value = `Usuário não autorizado. ${error}.`
        console.error('Erro ao carregar usuário:', error);
    }
}

//CARREGANDO ROLES
async function loadRoles(url){
    axios.get(url).then(({data}) => {
        const response = data.roles;
        listRoles.value = response;
    }).catch(error => {
        console.log('Erro ao carregar roles ', error);
    });
}

watch(search, (userSearch) => {
    loadUsers('api/users', userSearch, '');
});

watch(profile, (userProfile) => {
    loadUsers('api/users', '', userProfile);
});

onMounted(() => {
    console.log('index montado');
    loadUsers('api/users');
    loadRoles('api/roles');
});
</script>
