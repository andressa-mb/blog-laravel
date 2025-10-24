<template>
    <div class="modal fade show d-block" id="messageModal" tabindex="-1" role="dialog" style="background-color: rgba(0,0,0,0.5)">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header" :class="modalHeaderClass">
                    <h5 class="modal-title" id="messageModalLabel">
                        <i :class="modalIcon"></i>
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
                    <button type="button" class="btn" :class="modalButtonClass" @click="closeModal">
                        Fechar
                    </button>
                </div>
            </div>
        </div>
    </div>

</template>

<script setup>
import { onMounted, watch, reactive, ref, nextTick} from 'vue';

const modalIcon = ref('');
const modalHeaderClass = ref('');
const modalButtonClass = ref('');

const props = defineProps({
    modalTitle: String,
    modalMessage: String,
    modalMsgType: String
});

const emit = defineEmits(['closeModal']);

const closeModal = () => {
    emit('closeModal');
}

function setupModal(){
    console.log('setupmodal msg ', props.modalMsgType);
    if(props.modalMsgType === 'success'){
        modalIcon.value = 'fas fa-check-circle';
        modalHeaderClass.value = 'bg-success text-white'
        modalButtonClass.value = 'btn-success';
    }else {
        modalIcon.value = 'fas fa-exclamation-triangle';
        modalHeaderClass.value = 'bg-danger text-white';
        modalButtonClass.value = 'btn-danger';
    }
}

onMounted(() => {
    setupModal();
});

watch(props, () => {
    setupModal();
});

</script>
