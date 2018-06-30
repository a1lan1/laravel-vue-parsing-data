<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Parsing</div>

                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" class="form-control" v-model="textData" @keyup.enter="sendData" placeholder="Введите запрос и нажмите Enter">
                        </div>
                        <div id="parse"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function() {
            return {
                textData: ''
            }
        },
        methods: {
            sendData() {
                axios.post('/data', {data: this.textData}).then((response) => {
                    document.getElementById('parse').innerHTML = response.data.join('\n');
                    this.textData = '';
                });
            }
        }
    }
</script>
