<template>
    <div  class="container">
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
                    <a href="#" class="btn btn-warning">Editar</a>
                    <a href="#" class="btn btn-danger">Excluir</a>
                </div>
            </div>

        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';

const route = useRoute();
const users = ref({});

async function loadData(url){
    const response = await axios.get(url);
    users.value = response.data;
    console.log(response.data.data);
}

onMounted(() => {
    console.log('index montado');
    loadData('api/users');
});
</script>
