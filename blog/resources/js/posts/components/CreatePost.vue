<template>
    <div class="container">
        <form @submit.prevent="submitForm">
            <div class="form-group">
                <label for="title">Título:</label>
                <input type="text" class="form-control" id="title" name="title" v-model="form.title" min="5" max="100" required>
            </div>
            <div class="form-group">
                <label for="content">Conteúdo:</label>
                <textarea type="text" class="form-control" id="content" name="content" v-model="form.content" required />
            </div>
            <div class="form-group">
                <label for="author">Autor</label>
                <input type="text" class="form-control" id="author" name="author" v-model="form.user_id">
            </div>
            <div class="form-group form-check" v-for="cat in cats.data" :key="cat.id">
                <input type="checkbox" class="form-check-input" :id="`cat-${cat.id}`" :value="cat.id" name="categories[]" v-model="form.categories">
                <label class="form-check-label" :for="`cat-${cat.id}`">{{cat.id}} {{cat.name}}</label>
            </div>

            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
        <div class="mt-3">
            <p>dados do form</p>
            <p>{{form.title}}</p>
            <p>{{form.content}}</p>
            <p>{{form.user_id}}</p>
            <p>{{form.categories}}</p>
        </div>
    </div>

    <Message v-if="modal" :modalMessage="dataMessageModal" :modalType="dataTypeModal" @closeModal="close" />
</template>

<script setup>
import { onMounted, reactive, ref } from 'vue';
import { useRoute } from 'vue-router';
import Message from './modals/Message.vue';

const route = useRoute();
const cats = ref({});
const modal = ref(false);
const dataMessageModal = ref('');
const dataTypeModal = ref('');


const form = reactive({
    title: '',
    content: '',
    user_id: route.params.id,
    categories: [],
});

function close(){
    modal.value = false;
}

async function submitForm(){
    console.log('submit, dados: ');
    console.log(form.categories, form.title, form.content, form.user_id);
    await axios.post('api/posts', {
        title: form.title,
        content: form.content,
        user_id: form.user_id,
        categories: form.categories,
    }).then(resolve => {
        modal.value = true;
        dataTypeModal.value = 'success';
        dataMessageModal.value = 'Post inserido em nosso sistema com sucesso.';

        return resolve;
    }).catch((error) => {
        modal.value = true;
        dataTypeModal.value = 'danger';
        dataMessageModal.value = `Erro ao inserir o post do usuário. ${error}`;
        console.log('Erro ao criar post console: ', error);
        throw error;
    })
}

function loadCategories(url){
    axios.get(url).then( (response) => {
        cats.value = response.data;
        console.log('resposta do load ', response.data);
    }).catch((error) => {
        console.log('error: ', error);
    })
}

onMounted(() => {
    console.log('rota aqui: ', route.params.id);
    console.log('carregou tela de criar post');
    loadCategories('api/categories');
})

</script>
