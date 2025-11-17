import Posts from '../components/IndexPosts.vue';
import CreatePost from '../components/CreatePost.vue';

export default [
    {path: '/', component: Posts},
    {path: '/my-posts', component: Posts},
    {path: '/:id/create-post', component: CreatePost, name: 'create-post', props: true},
]
