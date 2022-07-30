<template>
    <div class="row">
        <div
            v-for="(column, columnIndex) in columns"
            :key="`column-${columnIndex}`"
            class="column"
        >
            <div class="card__header">
                <span class="card__title">
                    {{ column.title }}
                </span>
                <button
                    @click="handleDeleteColumn(column.id)"
                    class="btn__icon mdi mdi-close"
                />
            </div>
            <v-draggable :list="column.cards" group="cards" @change="handleCardMoved(column.id, column.cards, $event)">
                <div
                    v-for="(card, cardIndex) in column.cards"
                    :key="`card-${cardIndex}`"
                    @click="handleEditingCard(columnIndex, cardIndex)"
                    class="card"
                >
                    <div class="card__text">
                        {{ card.title }}
                    </div>
                    <i class="btn__icon mdi mdi-pencil"/>
                </div>
            </v-draggable>
            <div v-if="addingCardColumn && addingCardColumn.id === column.id">
                <input
                    :id="`card-field-${column.id}`"
                    v-model="cardTitleField"
                    class="input"
                />
                <div class="column__action">
                    <button
                        @click="handleAddCard"
                        class="btn btn__primary"
                    >Add
                    </button>
                    <button
                        @click="handleStopAddingCard"
                        class="btn btn__secondary__outlined"
                    >Close
                    </button>
                </div>
            </div>
            <button
                v-else
                @click="handleAddingCard(column)"
                class="btn btn__text"
            >
                <span class="mdi mdi-plus"/>
                Add a card
            </button>
        </div>
        <div class="column">
            <div v-if="isAddingColumn">
                <input
                    ref="columnField"
                    v-model="columnTitleField"
                    class="input"
                />
                <div class="column__action">
                    <button
                        @click="handleAddColumn"
                        class="btn btn__primary"
                    >Add
                    </button>
                    <button
                        @click="handleStopAddingColumn"
                        class="btn btn__secondary__outlined"
                    >Close
                    </button>
                </div>
            </div>
            <button
                v-else
                @click="handleAddingColumn"
                class="btn btn__text"
            >
                <span class="mdi mdi-plus"/>
                Add a list
            </button>
        </div>
        <modal-component
            v-if="editingCard"
            @close="handleStopEditingCard"
        >
            <template #header>
                <h3>Edit card</h3>
            </template>
            <template #body>
                <div>
                    <input
                        v-model="editingCardForm.title"
                        placeholder="Title..."
                    >
                </div>
                <div>
                    <input
                        v-model="editingCardForm.description"
                        placeholder="Description..."
                    >
                </div>
            </template>
            <template #footer>
                <div class="column__action">
                    <button
                        @click="handleUpdateCard"
                        class="btn btn__primary"
                    >Update
                    </button>
                    <button
                        @click="handleStopEditingCard"
                        class="btn btn__secondary__outlined"
                    >Close
                    </button>
                </div>
            </template>
        </modal-component>
    </div>
</template>

<script>
import Vue from "vue";
import VDraggable from "vuedraggable";
import ModalComponent from "./ModalComponent";

export default {
    components: {
        VDraggable,
        ModalComponent,
    },
    mounted() {
        this.fetchColumns();
    },
    data() {
        return {
            isLoading: false,
            columnTitleField: '',
            isAddingColumn: false,
            columns: [],
            addingCardColumn: null,
            cardTitleField: '',
            editingCard: null,
            editingCardForm: null,
        }
    },
    methods: {
        fetchColumns() {
            this.isLoading = true;
            axios.get('/columns').then((response) => {
                this.columns = response.data;
            }).finally(() => {
                this.isLoading = false;
            })
        },
        handleAddingColumn() {
            this.columnTitleField = ''
            this.isAddingColumn = true;
            Vue.nextTick(() => {
                this.$refs.columnField.focus();
            })
        },
        handleStopAddingColumn() {
            this.isAddingColumn = false;
            this.columnTitleField = ''
        },
        handleAddColumn() {
            axios.post('/columns', {
                title: this.columnTitleField,
                order: this.columns.length,
            }).then((response) => {
                this.columns.push(response.data)
                this.handleStopAddingColumn();
            }).catch(() => {
                alert('Add column failed');
            })
        },
        handleAddingCard(column) {
            this.cardTitleField = ''
            this.addingCardColumn = column;
            Vue.nextTick(() => {
                document.getElementById(`card-field-${column.id}`).focus();
            })
        },
        handleStopAddingCard() {
            this.addingCardColumn = null;
            this.cardTitleField = ''
        },
        handleAddCard() {
            axios.post(`/columns/${this.addingCardColumn.id}/cards`, {
                title: this.cardTitleField,
                order: this.addingCardColumn.cards.length,
            }).then((response) => {
                this.addingCardColumn.cards.push(response.data)
                this.handleStopAddingCard();
            }).catch(() => {
                alert('Add card failed');
            })
        },
        handleDeleteColumn(id) {
            axios.delete(`/columns/${id}`).then(() => {
                this.columns = this.columns.filter(column => column.id !== id)
            })
        },
        handleCardMoved(columnId, cards, event) {
            if (event.hasOwnProperty('moved') || event.hasOwnProperty('added')) {
                axios.post(`/columns/${columnId}/cards/moved`, {
                    cards: cards,
                })
            }
        },
        handleEditingCard(columnIndex, cardIndex) {
            this.editingCard = this.columns[columnIndex].cards[cardIndex];
            this.editingCardForm = Object.assign({
            }, this.editingCard);
        },
        handleStopEditingCard() {
            this.editingCard = null;
            this.editingCardForm = null;
        },
        handleUpdateCard() {
            axios.put(`/cards/${this.editingCard.id}`, {
                title: this.editingCardForm.title,
                description: this.editingCardForm.description,
            }).then((response) => {
                this.editingCard.title = response.data.title;
                this.editingCard.description = response.data.description;
                this.handleStopEditingCard();
            }).catch(() => {
                alert('Update card failed');
            })
        }
    }
}
</script>
