<template>
    <div>
        <jet-form-section @submitted="createEstate">
            <template #title>
                Create Estate
            </template>

            <template #description>
                Allow registration of a estate with some characteristics:
                email must be valid, email, street, neighborhood, city and state are required fields.
            </template>

            <template #form>

                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="owner_id" value="Email" />
                    <multiselect v-model="createEstateForm.owner_id"
                                 label="email"
                                 track-by="id"
                                 :allow-empty="false"
                                 :options="owners"
                                 :show-labels="true"
                                 class="mt-1 block rounded-md shadow-sm">
                    </multiselect>
                    <jet-input-error :message="createEstateForm.error('owner_id')" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="state" value="State" />
                    <jet-input id="state" type="text" class="mt-1 block w-full" v-model="createEstateForm.state" autofocus />
                    <jet-input-error :message="createEstateForm.error('state')" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="city" value="City" />
                    <jet-input id="city" type="text" class="mt-1 block w-full" v-model="createEstateForm.city" autofocus />
                    <jet-input-error :message="createEstateForm.error('city')" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="neighborhood" value="Neighborhood" />
                    <jet-input id="neighborhood" type="text" class="mt-1 block w-full" v-model="createEstateForm.neighborhood" autofocus />
                    <jet-input-error :message="createEstateForm.error('neighborhood')" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="street" value="Street" />
                    <jet-input id="street" type="text" class="mt-1 block w-full" v-model="createEstateForm.street" autofocus />
                    <jet-input-error :message="createEstateForm.error('street')" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="number" value="Number" />
                    <jet-input id="number" type="text" class="mt-1 block w-full" v-model="createEstateForm.number" autofocus />
                    <jet-input-error :message="createEstateForm.error('number')" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="details" value="Details" />
                    <textarea id="details" rows="5" cols="33" class="form-input rounded-md shadow-sm mt-1 block w-full" v-model="createEstateForm.details" autofocus ></textarea>
                    <jet-input-error :message="createEstateForm.error('details')" class="mt-2" />
                </div>

            </template>

            <template #actions>
                <jet-action-message :on="createEstateForm.recentlySuccessful" class="mr-3">
                    Created.
                </jet-action-message>

                <jet-button :class="{ 'opacity-25': createEstateForm.processing }" :disabled="createEstateForm.processing">
                    Create
                </jet-button>
            </template>
        </jet-form-section>

        <div v-if="estates.length > 0">
            <jet-section-border />

            <div class="mt-10 sm:mt-0">
                <jet-action-section>
                    <template #title>
                        Manage Estates
                    </template>

                    <template #description>
                        You can safely delete any of your existing properties.
                    </template>

                    <template #content>
                        <div class="space-y-6">
                            <div class="flex items-center justify-between" v-for="estate in estates">
                                <div>
                                    {{ estate.short_address }}
                                </div>

                                <div class="flex items-center">
                                    <div class="text-sm text-gray-400" v-if="estate.owner">
                                        Belongs to {{ estate.owner.email }}
                                    </div>

                                    <button class="cursor-pointer ml-6 text-sm text-red-500 focus:outline-none" @click="confirmEstateDeletion(estate)">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </jet-action-section>
            </div>
        </div>

        <jet-confirmation-modal :show="estateBeingDeleted" @close="estateBeingDeleted = null">
            <template #title>
                Delete Estate
            </template>

            <template #content>
                Are you sure you would like to delete this Estate?
            </template>

            <template #footer>
                <jet-secondary-button @click.native="estateBeingDeleted = null">
                    Nevermind
                </jet-secondary-button>

                <jet-danger-button class="ml-2" @click.native="deleteEstate" :class="{ 'opacity-25': deleteEstateForm.processing }" :disabled="deleteEstateForm.processing">
                    Delete
                </jet-danger-button>
            </template>
        </jet-confirmation-modal>
    </div>
</template>

<script>
    import JetFormSection from './../../Jetstream/FormSection'
    import JetActionMessage from "../../Jetstream/ActionMessage";
    import JetActionSection from "../../Jetstream/ActionSection";
    import JetButton from "../../Jetstream/Button";
    import JetConfirmationModal from "../../Jetstream/ConfirmationModal";
    import JetDangerButton from "../../Jetstream/DangerButton";
    import JetDialogModal from "../../Jetstream/DialogModal";
    import JetInput from "../../Jetstream/Input";
    import JetInputError from "../../Jetstream/InputError";
    import JetLabel from "../../Jetstream/Label";
    import JetSecondaryButton from "../../Jetstream/SecondaryButton";
    import JetSectionBorder from "../../Jetstream/SectionBorder";
    import Multiselect from 'vue-multiselect'

    export default {
        components: {
            JetActionMessage,
            JetActionSection,
            JetButton,
            JetConfirmationModal,
            JetDangerButton,
            JetDialogModal,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
            JetSecondaryButton,
            JetSectionBorder,
            Multiselect,
        },

        props: [
            'estates',
        ],

        data() {
            return {
                createEstateForm: this.$inertia.form({
                    owner_id: null,
                    state: '',
                    city: '',
                    neighborhood: '',
                    street: '',
                    number: '',
                    details: '',
                }, {
                    bag: 'estateStore',
                    resetOnSuccess: true,
                }),

                owners: [],

                deleteEstateForm: this.$inertia.form(),
                estateBeingDeleted: null,
            }
        },

        created: function () {
            axios.get(route('owners.select-input'),{
                preserveState: true
            }).then(response => {
                this.owners = response.data
            });
        },

        methods: {
            createEstate() {
                this.createEstateForm.owner_id  = this.createEstateForm.owner_id.id

                this.createEstateForm.post(route('estates.store'), {
                    preserveScroll: true,
                })
            },

            confirmEstateDeletion(estate) {
                this.estateBeingDeleted = estate
            },

            deleteEstate() {
                this.deleteEstateForm.delete(route('estates.destroy', this.estateBeingDeleted), {
                    preserveScroll: true,
                    preserveState: true,
                }).then(() => {
                    this.estateBeingDeleted = null
                })
            },
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
