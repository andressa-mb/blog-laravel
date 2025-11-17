<template>
    <div class="modal fade show d-block" id="messageModal" tabindex="-1" role="dialog" style="background-color: rgba(0,0,0,0.5)">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" :class="modalHeaderClass">
                    <h5 class="modal-title" id="messageModalLabel">
                        <i :class="modalIconClass"></i>
                        {{ modalTitle }}
                    </h5>
                    <button type="button" class="close" @click="closeModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ modalMessage }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="closeModal">
                        Fechar
                    </button>
                </div>
            </div>
        </div>
    </div>

</template>

<script setup>
import { onMounted, ref } from 'vue';

const modalHeaderClass = ref('');
const modalIconClass = ref('');
const modalTitle = ref('');
const modalMessage = ref('');

const props = defineProps({
    modalType: String,
    modalMessage: String
})

const emits = defineEmits('closeModal');

function closeModal(){
    emits('closeModal');
}

function setupModal() {
    if(props.modalType == 'success'){
        modalHeaderClass.value = 'bg bg-success';
        modalIconClass.value = 'clipboard2-check';
        modalTitle.value = 'Novo post inserido';
        modalMessage.value = props.modalMessage;
    } else {
        modalHeaderClass.value = 'bg bg-danger';
        modalIconClass.value = 'clipboard2-minus';
        modalTitle.value = 'Erro';
        modalMessage.value = props.modalMessage;
    }
}

onMounted(() => {
    setupModal();
})

</script>
