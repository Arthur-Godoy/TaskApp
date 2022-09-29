let quant = 1;

const addSubtaskField = () =>{
    let subtask =`<div class="d-inline" id="id${quant}">
                        <input style="width: 90%" class="mt-3 form-control bg-transparent text-light d-inline" type="text" name="subtasks[]" placeholder="Ex: Fazer Café" required>
                    </div>
                    <div class="d-inline" id="btnsid${quant}">
                        <button type="button" class="btn btn-outline d-inline btn-sm" onclick="removeSubtaskField('id${quant}');"><ion-icon name="close" class="fs-5"></ion-icon></button>
                    </div>`

    document.getElementById('subtasks').insertAdjacentHTML('beforeend',subtask)
    quant++
}

const removeSubtaskField = (id) =>{
    console.log(id);
    document.getElementById(id).innerHTML = ' '
    document.getElementById('btns'+id).className = "d-none"
}

