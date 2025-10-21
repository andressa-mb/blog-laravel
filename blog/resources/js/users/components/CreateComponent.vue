<template>
    <div class="container">
        <div>
            <Message
                v-if="modalOpen"
                :modalMessage="modalMessage"
                :modalTitle="modalTitle"
                :modalMsgType="modalMsgType"
                @closeModal="closeModal"
            />
        </div>
        <form @submit.prevent="submitForm">
            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" class="form-control" id="name" name="name" v-model="form.name">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email" v-model="form.email">
                <small id="emailHelp" class="form-text text-muted">Nunca compartilhar seu e-mail.</small>
            </div>
            <div class="form-group">
                <label for="password">Senha:</label>
                <input type="password" class="form-control" id="password" name="password" v-model="form.password">
            </div>
            <div class="form-group">
                <label for="password-confirm">Confirmar senha:</label>
                <input type="password" class="form-control" id="password-confirm" name="password-confirm" v-model="form.password_confirmation">
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="admin" value="admin" name="roles[]" v-model="form.roles">
                <label class="form-check-label" for="admin">Administrador</label>
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="reader" value="reader" name="roles[]" v-model="form.roles">
                <label class="form-check-label" for="reader">Leitor</label>
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="author" value="author" name="roles[]" v-model="form.roles">
                <label class="form-check-label" for="author">Autor</label>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>

        <div>
            <p>dados do form</p>
            <p>{{form.name}}</p>
            <p>{{form.email}}</p>
            <p>{{form.password}}</p>
            <p>{{form.password_confirm}}</p>
            <p>{{form.roles}}</p>

        </div>

    </div>
</template>

<script setup>
import { reactive, ref } from 'vue';
import Message from './modals/Message.vue';

const modalOpen= ref(false);
const modalTitle = ref('');
const modalMessage = ref('');
const modalMsgType = ref('');


const form = reactive({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    roles: [],
});

const closeModal = () => {
    modalOpen.value = false;
}

async function sendForm(url){
    try{
        const response = await axios.post(url, {
            name: form.name,
            email: form.email,
            password: form.password,
            password_confirmation: form.password_confirmation,
            roles: form.roles
        });

        return response;
    }catch (error) {
        console.error('Erro na requisição:', error);
        throw error;
    }
}

async function submitForm(){
    try{
        console.log('Dados do formulário:', form);
        const createUser = await sendForm("api/admin/create");
        if(createUser) {
            console.log('Usuário criado com sucesso.');
            form.name = "",
            form.email = "",
            form.password = "",
            form.password_confirmation = "",
            form.roles = []
            modalOpen.value = true;
            modalTitle.value = "Sucesso!";
            modalMessage.value = "Usuário inserido com sucesso no sistema.";
            modalMsgType.value = 'success';
    console.log(modalTitle.value);
    console.log(modalOpen.value);
        }
    }catch(error){
        modalOpen.value = true;
        modalTitle.value = "Erro!";
        modalMessage.value = `Erro ao inserir no sistema. ${error.response ? error.response.data : error}`;
        modalMsgType.value = 'error';
        console.log('erro ao conectar ao banco. ' + error.response ? error.response.data : error);
    }
}

</script>
