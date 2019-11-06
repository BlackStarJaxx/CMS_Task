<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Login</div>
                    <div class="card-body">
                        <form @click="handleSubmit">
                            <div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label text-md-right">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" v-model="email" required autofocus>
                                    <small class="text-success" v-if="!email">Enter Email</small>
                                    <small class="text-danger" v-else-if="email">Enter valid Email</small>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" v-model="password" required>
                                    <small class="text-success" v-if="!password">Enter Your Password</small>
                                    <small class="text-danger" v-else="!password.password">It's a bad pass</small>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary"  >
                                        Login
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                email: "",
                password: ""
            }
        },
        methods: {
            handleSubmit(e) {
                e.preventDefault()
                if (this.password.length > 0) {
                    let email = this.email
                    let password = this.password

                    axios.post('api/login', {email, password}).then(response => {
                        let user = response.data.user
                        let is_admin = user.is_admin

                        localStorage.setItem('bigStore.user', JSON.stringify(user))
                        localStorage.setItem('bigStore.jwt', response.data.token)

                        if (localStorage.getItem('bigStore.jwt') != null) {
                            this.$emit('loggedIn')
                            if (this.$route.params.nextUrl != null) {
                                this.$router.push(this.$route.params.nextUrl)
                            } else{
                                this.$router.push((is_admin == 1 ? 'admin' : 'dashboard'))
                            }

                        }
                    });


                }




            }
        }
    }
</script>

