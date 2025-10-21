<template>
    <div id="app" class="container">
        <p>LISTA DE USUÁRIOS</p>
        <div v-if="errorMsg" class="alert alert-danger">
            {{ errorMsg }}
        </div>

        <ul v-for="(user, index) in users" :key="index">
            <li>{{index}} / {{user.name}}</li>
        </ul>

    </div>
</template>

<script setup>
import {ref, onMounted} from 'vue';
const users = ref({});
const errorMsg = ref("");


async function loadData(url) {
    errorMsg.value = '';
    try{
        const response = await axios.get(url);
        console.log(response);
        return users.value = response.data.data;
    }catch(error){
        errorMsg.value = `Erro ${error.response.status}: ${error.response.data.message || 'Erro desconhecido'}`;
        console.error('Erro ao buscar os dados. data ', error.data);
    }

    users.value = [];
}

onMounted(async () => {

    console.log('montado');
    loadData('api/users');

})

</script>
