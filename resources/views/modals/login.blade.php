<login inline-template> 
    <modal name="login" height="auto">
        <form action="" class="p-10" @submit.prevent="login">
            <div class="mb-6">
                <label for="email" class="block uppercase tracking-wide mb-2 font-bold text-xs text-grey-darker">Email</label>
                <input class="p-2 w-full" 
                    type="email" 
                    name="email" 
                    id="email" 
                    placeholder="johndoe@example.com" 
                    autocomplete="email" 
                    v-modal="form.email" 
                    required
                />
            </div>
            <div class="mb-6">
                <label for="password" class="block uppercase tracking-wide mb-2 font-bold text-xs text-grey-darker">Password</label>
                <input class="p-2 w-full" 
                    type="password" 
                    name="password" 
                    id="password" 
                    autocomplete="current-password" 
                    v-modal="form.password" 
                    required
                />
            </div>

            <div class="flex -mx-4 ">
                <button type="submit" class="btn bg-green-lighter hover:bg-green-dark flex-1 mx-4" :class="loading? 'loader':''" >Log In</button>
                <button type="button" class="btn flex-1 mx-4" @click="$modal.hide('login')">Cancel</button>
            </div>
            <div v-if="feedback" class="mt-6">
                <span class="text-xs text-red" v-text="feedback"></span>
            </div>
        </form>
    </modal>
</login>