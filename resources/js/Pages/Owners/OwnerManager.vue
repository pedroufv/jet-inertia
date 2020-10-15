<template>
    <div>
        <jet-form-section @submitted="createOwner">
            <template #title>
                Create Owner
            </template>

            <template #description>
                Allow registration of a owner with some characteristics:
                full name, e-mail must be valid and unique, type (legal or private) and identifier according to type.
            </template>

            <template #form>
                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="name" value="Name" />
                    <jet-input id="name" type="text" class="mt-1 block w-full" v-model="createOwnerForm.name" autofocus />
                    <jet-input-error :message="createOwnerForm.error('name')" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="email" value="Email" />
                    <jet-input id="email" type="text" class="mt-1 block w-full" v-model="createOwnerForm.email" autofocus />
                    <jet-input-error :message="createOwnerForm.error('email')" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="type" value="Type" />
                    <select name="type" class="border block w-full shadow p-2 bg-white" v-model="createOwnerForm.type" autofocus>
                        <option value="private">Private</option>
                        <option value="legal">Legal</option>
                    </select>
                    <jet-input-error :message="createOwnerForm.error('type')" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-4">
                    <jet-label for="identifier" value="Identifier" />
                    <jet-input id="identifier"
                               type="text"
                               class="mt-1 block w-full"
                               v-model="createOwnerForm.identifier"
                               v-mask="['###.###.###-##', '##.###.###/####-##']"
                               autofocus />
                    <jet-input-error :message="createOwnerForm.error('identifier')" class="mt-2" />
                </div>

            </template>

            <template #actions>
                <jet-action-message :on="createOwnerForm.recentlySuccessful" class="mr-3">
                    Created.
                </jet-action-message>

                <jet-button :class="{ 'opacity-25': createOwnerForm.processing }" :disabled="createOwnerForm.processing">
                    Create
                </jet-button>
            </template>
        </jet-form-section>

        <div v-if="owners.length > 0">
            <jet-section-border />

            <div class="mt-10 sm:mt-0">
                <jet-action-section>
                    <template #title>
                        Manage Owners
                    </template>

                    <template #description>
                        You may delete any of your existing owners if they are no related to a estate.
                    </template>

                    <template #content>
                        <div class="space-y-6">
                            <div class="flex items-center justify-between" v-for="owner in owners">
                                <div>
                                    {{ owner.name }}
                                </div>

                                <div>
                                    {{ owner.email }}
                                </div>

                                <div class="flex items-center">
                                    <div class="text-sm text-gray-400">
                                        Has {{ owner.estates.length }} estates
                                    </div>

                                    <button class="cursor-pointer ml-6 text-sm text-gray-400 underline focus:outline-none"
                                            @click="manageOwnerEstates(owner)"
                                            v-if="unowned.concat(owner.estates).length > 0">
                                        Estates
                                    </button>

                                    <button class="cursor-pointer ml-6 text-sm text-red-500 focus:outline-none" @click="confirmOwnerDeletion(owner)">
                                        Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </template>
                </jet-action-section>
            </div>
        </div>

        <jet-dialog-modal :show="managingEstatesFor" @close="managingEstatesFor = null">
            <template #title>
                Onwer Estates
            </template>

            <template #content>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div v-for="estate in availableEstates">
                        <label class="flex items-center">
                            <input type="checkbox" class="form-checkbox" :value="estate.id" v-model="updateOwnerForm.estates">
                            <span class="ml-2 text-sm text-gray-600">{{ estate.short_address }}</span>
                        </label>
                    </div>
                </div>
            </template>

            <template #footer>
                <jet-secondary-button @click.native="managingEstatesFor = null">
                    Nevermind
                </jet-secondary-button>

                <jet-button class="ml-2" @click.native="updateOwner" :class="{ 'opacity-25': updateOwnerForm.processing }" :disabled="updateOwnerForm.processing">
                    Save
                </jet-button>
            </template>
        </jet-dialog-modal>

        <jet-confirmation-modal :show="ownerBeingDeleted" @close="ownerBeingDeleted = null">
            <template #title>
                Delete Owner
            </template>

            <template #content>
                Are you sure you would like to delete this Owner?
            </template>

            <template #footer>
                <jet-secondary-button @click.native="ownerBeingDeleted = null">
                    Nevermind
                </jet-secondary-button>

                <jet-danger-button class="ml-2" @click.native="deleteOwner" :class="{ 'opacity-25': deleteOwnerForm.processing }" :disabled="deleteOwnerForm.processing">
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
    import {mask} from 'vue-the-mask';

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
        },

        directives: {mask},

        props: [
            'owners',
            'unowned',
        ],

        data() {
            return {
                createOwnerForm: this.$inertia.form({
                    name: '',
                    email: '',
                    type: '',
                    identifier: '',
                }, {
                    bag: 'ownerStore',
                    resetOnSuccess: true,
                }),

                updateOwnerForm: this.$inertia.form({
                    estates: []
                }, {
                    resetOnSuccess: false,
                    bag: 'ownerUpdate',
                }),

                availableEstates: [],
                managingEstatesFor: null,

                deleteOwnerForm: this.$inertia.form(),
                ownerBeingDeleted: null,
            }
        },

        methods: {
            createOwner() {
                this.createOwnerForm.post(route('owners.store'), {
                    preserveScroll: true,
                }).catch(error => {
                })
            },

            manageOwnerEstates(owner) {
                let estatesIds = owner.estates.map( estate => estate.id)

                this.availableEstates = this.unowned.concat(owner.estates);

                this.updateOwnerForm.estates = estatesIds

                this.managingEstatesFor = owner
            },

            updateOwner() {
                this.updateOwnerForm.put(route('owners.update', this.managingEstatesFor), {
                    preserveScroll: true,
                    preserveState: true,
                }).then(response => {
                    this.managingEstatesFor = null
                })
            },

            confirmOwnerDeletion(owner) {
                this.ownerBeingDeleted = owner
            },

            deleteOwner() {
                this.deleteOwnerForm.delete(route('owners.destroy', this.ownerBeingDeleted), {
                    preserveScroll: true,
                    preserveState: true,
                }).then(() => {
                    this.ownerBeingDeleted = null
                })
            },
        }
    }
</script>
