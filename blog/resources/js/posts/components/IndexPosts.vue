<template>
    <div class="container">
        <div v-if="hasError" class="shadow-sm p-3 mb-5 bg-white rounded">
            <h4>Erro ao carregar posts.</h4>
            <p class="user-select-all">
                {{msgError}}
            </p>
        </div>

         <!-- PAGINAÇÃO -->
        <div class="mb-3">
            <button class="btn btn-info mx-2" v-if="posts.links" @click="loadPosts(posts.links.first)">1</button>
            <button class="btn btn-primary mx-2" v-if="posts.links && posts.links.prev != null" @click="loadPosts(posts.links.prev)">
                <i class="bi bi-box-arrow-left"></i>
            </button>

            <button class="btn btn-secondary border rounded border-dark border-top-0 text-center mx-2" v-if="posts.meta" disabled>{{posts.meta.current_page}}</button>
            <button class="btn btn-light border-dark border-top-0 text-center mx-2" v-if="posts.meta" disabled>Total: {{posts.meta.total}}</button>

            <button class="btn btn-primary mx-2" v-if="posts.links && posts.links.next != null" @click="loadPosts(posts.links.next)">
                <i class="bi bi-box-arrow-right"></i>
            </button>
            <button class="btn btn-info mx-2" v-if="posts.links" @click="loadPosts(posts.links.last)">{{posts.meta.last_page}}</button>
        </div>

        <div class="row" v-if="posts.data">
            <div class="col-md-12 text-center">
                <h4>{{title}}</h4>
            </div>
            <div class="col-md-12" v-for="post in posts.data" :key="post.id">
                <div class="card mb-4 shadow-sm">
                    <div class="card-header text-white bg-secondary">
                        <div class="d-flex justify-content-between">
                            <h4>{{post.title}}</h4>
                            <h4><em>Created by: {{post.author.name}}</em></h4>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <div v-if="thumbImage(post.images)">
                            <img :src="`storage/${thumbImage(post.images).path}`" :width="thumbImage(post.images).width" :height="thumbImage(post.images).height" :alt="thumbImage(post.images).description">
                        </div>
                        <div v-else>
                            <p>Sem imagem atribuída</p>
                        </div>
                    </div>

                    <div class="card-body">
                        <p class="card-text mb-auto">{{post.content}}</p>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-outline-secondary" @click="viewPost(post)">View</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary">Delete</button>
                            </div>
                            <small class="text-muted">Inserido em: {{post.created_at}}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- PAGINAÇÃO -->
        <div class="mt-3">
            <button class="btn btn-info mx-2" v-if="posts.links" @click="loadPosts(posts.links.first)">1</button>
            <button class="btn btn-primary mx-2" v-if="posts.links && posts.links.prev != null" @click="loadPosts(posts.links.prev)">
                <i class="bi bi-box-arrow-left"></i>
            </button>

            <button class="btn btn-secondary border rounded border-dark border-top-0 text-center mx-2" v-if="posts.meta" disabled>{{posts.meta.current_page}}</button>

            <button class="btn btn-primary mx-2" v-if="posts.links && posts.links.next != null" @click="loadPosts(posts.links.next)">
                <i class="bi bi-box-arrow-right"></i>
            </button>
            <button class="btn btn-info mx-2" v-if="posts.links" @click="loadPosts(posts.links.last)">{{posts.meta.last_page}}</button>
        </div>

        <!-- MODAL -->
        <PostModal v-if="modal" :postId="selectedPost.id" @close="closeModal" />
    </div>
</template>

<script setup>
import { onMounted, ref, watch } from 'vue';
import { useRoute } from 'vue-router';
import PostModal from './modals/post/Post.vue';

const route = useRoute();
const posts = ref({});
const path = ref('');
const title = ref('');
const hasError = ref(false);
const msgError = ref('');
const modal = ref(false);
const selectedPost = ref({});

function viewPost(post){
    try{
        selectedPost.value = post;
        modal.value = true;
    }catch(error){
        console.log('erro pra view post ', error);
    }
}

function closeModal(){
    modal.value = false;
}

function thumbImage(hasImages){
    if(hasImages.length > 0){
        for(let image of hasImages){
            if(image.type === 2){
                return image;
            }
        }
    }else {
        return null;
    }
}

async function loadPosts(url){
    axios.get(url).then(({data}) => {
        posts.value = data;
    }).catch((error) => {
        hasError.value = true;
        msgError.value = error;
        console.log('Erro ao carregar posts: ', error);
    });
}

watch( () => route.path, (newPath) => {
    if (newPath.includes('/my-posts')) {
        title.value = "Meus Posts";
        loadPosts('api/posts');
    } else{
        title.value = "Posts registrados no sistema";
        loadPosts('/api/admin/all-posts');
    }
},   { immediate: true } );

onMounted(() => {
    path.value = route.path;
});
</script>
