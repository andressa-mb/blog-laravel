<template>
    <div>
        <div class="modal fade show d-block" id="messageModal" tabindex="-1" role="dialog" style="background-color: rgba(0,0,0,0.5)">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header" :class="modalHeaderClass">
                        <h5 class="modal-title" id="messageModalLabel">
                            <i :class="modalIcon"></i>
                            {{ isEdit ? 'Editar usuário' : 'Excluir usuário' }}
                        </h5>
                        <button type="button" class="close" @click="close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Nome: </label>
                            <input id="name" type="text" v-model="form.name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="text" v-model="form.email" class="form-control">
                        </div>
                        <div class="form-group" v-if="!isEdit">
                            <label>Perfil do Usuário</label>
                            <div class="mb-3">
                                <span v-for="role in form.roles" :key="role" class="badge badge-primary mr-2">
                                    {{ role }}
                                </span>
                                <span v-if="form.roles.length === 0" class="text-muted">
                                    Nenhuma role atribuída
                                </span>
                            </div>
                        </div>

                        <div class="form-group" v-if="isEdit">
                            <label>Atribuir/Remover Perfis</label>
                            <div v-for="role in listRoles" :key="role.id" class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <input
                                            type="checkbox"
                                            :value="role.name"
                                            v-model="form.roles"
                                            :id="role.id"
                                        >
                                    </div>
                                </div>
                                <label :for="role.id" class="form-control">
                                    {{role.name}}
                                </label>
                            </div>
                        </div>
                        <div>
                            {{originalForm}}
                        </div>
                        <div>
                            {{form}}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn" :class="modalButtonClass" @click="sendChanges()">
                            {{ isEdit ? 'Atualizar' : 'Excluir' }}
                        </button>
                        <button type="button" class="btn btn-secondary" @click="close">
                            Fechar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <Message
            v-if="modalMsgOpen"
            :modalMessage="modalMessage"
            :modalTitle="modalTitle"
            :modalMsgType="modalMsgType"
            @closeModal="closeModal"
        />
    </div>
</template>

<script setup>
import { ref, onMounted, reactive, watch } from 'vue';
import Message from '../Message.vue';

const modalIcon = ref('');
const modalHeaderClass = ref('');
const modalButtonClass = ref('');
const modalMsgOpen = ref(false);
const modalMessage = ref("");
const modalTitle = ref("");
const modalMsgType = ref("");
const user = ref({});
const listRoles = ref({});
const originalForm = ref({
    name: '',
    email:'',
    roles: [],
});

const props = defineProps({
    userId: {type: Number, required: true},
    isEdit: {type: Boolean, required: true},
});

const emits = defineEmits(['closeMod']);
function close() {
    emits('closeMod');
};

function closeModal(){
    modalMsgOpen.value = false;
    emits('closeMod');
}

const form = reactive({
    name: '',
    email:'',
    roles: [],
});

//EDIÇÃO DO USUARIO
function hasChanges() {
    return (
        form.name !== originalForm.value.name ||
        form.email !== originalForm.value.email ||
        JSON.stringify(form.roles.sort()) !== JSON.stringify(originalForm.value.roles.sort())
    );
}

function sendChanges(){
    if(props.isEdit){
        if(!hasChanges()){
            closeModal();
            return;
        }
        if(JSON.stringify(form.roles) === "[]"){
            form.roles = ["reader"];
        }
        editUser(`api/users/${props.userId}`);
    }
}

async function editUser(url){
    await axios.put(url, {
            name: form.name,
            email: form.email,
            roles: form.roles
        }).then(response => {
            modalMsgType.value = 'success';
            modalTitle.value = 'Editado com sucesso!';
            modalMessage.value = `#${response.data.data.user.id} | Usuário: ${response.data.data.user.name} atualizado. | Status: ${response.statusText}`
            modalMsgOpen.value = true;
        }).catch(error => {
            modalMsgType.value = 'danger';
            modalTitle.value = 'Erro ao editar o usuário!';
            modalMessage.value = `Erro ao editar usuário. | ${error}`;
            modalMsgOpen.value = true;
            console.log('erro do axios edit ', error)
        });
}

//MONTANDO OS DADOS DO MODAL
function setupModal() {
    if(props.isEdit) {
        modalHeaderClass.value = 'bg-primary text-white';
        modalButtonClass.value = 'bg-success text-white';
        modalIcon.value = 'bi bi-pencil';
    }else {
        modalHeaderClass.value = 'bg-danger text-white';
        modalButtonClass.value = 'bg-danger text-white';
        modalIcon.value = 'bi bi-trash';
    }
}

//CARREGANDO DADOS DO USUARIO
async function loadUser(url){
    axios.get(url).then(({data}) => {
        const response = data?.data;
        user.value = response.user;
        form.name = response?.user.name || '';
        form.email = response?.user.email || '';
        form.roles = response?.relations.roles || [];

        originalForm.value = {
            name: response?.user.name || '',
            email: response?.user.email || '',
            roles: response?.relations.roles || [],
        }
    }).catch(error => {
        console.log('erro carregando user: ', error);
    });
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

//VERIFICANDO ATUALIZAÇÕES
watch(() => props.userId, (newUserId) => {
    if(newUserId){
        loadUser(`api/users/${newUserId}`);
        console.log('watch props new User id: ' + newUserId);
    }
}, { immediate: true })

//MONTANDO O COMPONENTE
onMounted(() => {
    setupModal();
    loadUser(`api/users/${props.userId}`);
    loadRoles(`api/roles`);
});
</script>
