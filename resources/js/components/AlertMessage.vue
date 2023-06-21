<template>
    <div class="message-body">
        <div id="session-message" class="alert alert-dark alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ message }}
        </div>
    </div>
</template>

<script>
export default {
    name: "DashboardAlertMessage",
    props: [
        'message',
    ],
    created() {
        setTimeout(() => {
            document.getElementById('session-message').remove()
        }, 3500);
    }
}
</script>

<style scoped>
.message-body {
    position: fixed;
    right: 10px;
    bottom: 5px;
    z-index: 99999999999999999999;
}
</style>
