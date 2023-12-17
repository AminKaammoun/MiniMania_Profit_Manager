<template>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse">
                <div class="navbar-nav">

                    <router-link to="/" class="btn btn-secondary">Home</router-link>

                    <router-link to="/items" class="btn btn-primary">Items</router-link>
                    <router-link to="/categories" class="btn btn-primary">Categories</router-link>
                    <router-link to="/types" class="btn btn-primary">Types</router-link>

                </div>
            </div>
        </nav>
        <router-view> </router-view>
    </div>
</template>
<script>
export default {}
</script>