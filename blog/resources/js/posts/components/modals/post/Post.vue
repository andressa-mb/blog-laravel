<template>
    <div>
        <div class="modal fade show d-block" id="postModal" tabindex="-1" role="dialog" style="background-color: rgba(0,0,0,0.5)">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="messageModalLabel">
                            <i class="fa fa-arrow"></i>
                        </h5>
                        <button type="button" class="close" @click="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" v-for="post in dataPost" :key="post.id">
                        <h5>Título: {{post.post.title}}</h5>
                        <h6 class="text-muted">Inserido por: {{post.post.user_id.name}}</h6>
                        <div class="border border-secondary">
                            <p class="p-3">{{post.post.content}}</p>
                        </div>
                        <div v-if="post.relations.categories.length > 0" class="mt-3 border border-secondary" >
                            <h5 class="p-3">Categorias:</h5>
                            <ul class="p-3">
                                <li v-for="category in post.relations.categories" :key="category.id">{{category}}</li>
                            </ul>
                        </div>
                        <div class="modal-footer alert alert-info mt-3">
                            <p class="text-right">Cadastrado em: {{post.post.created_at}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const dataPost = ref({});

const props = defineProps({
    postId: {type: Number, required: true}
});

const emit = defineEmits(['close']);

function close(){
    emit('close');
}

async function loadPost(url){
    axios.get(url).then((response) => {
        dataPost.value = response.data;
    }).catch( (error) => {
        console.log('erro axios: ', error);
    })
}

onMounted(() => {
    loadPost(`api/posts/${props.postId}`)
})



</script>
