let quant = 1;

const addSubtaskField = (target) =>{
    let subtask =`<div class="d-inline" id="${target}${quant}">
                        <input style="width: 90%" class="mt-3 form-control bg-transparent text-light d-inline" type="text" name="subtasks[]" placeholder="Ex: Fazer Café" required>
                    </div>
                    <div class="d-inline" id="btn${target}${quant}">
                        <button type="button" class="btn btn-outline d-inline btn-sm" onclick="removeSubtaskField('${target}${quant}');"><ion-icon name="close" class="fs-5"></ion-icon></button>
                    </div>`

    document.getElementById(`subtasks${target}`).insertAdjacentHTML('beforeend',subtask)
    quant++
}

const removeSubtaskField = (id) =>{
    console.log(id);
    document.getElementById(id).innerHTML = ' '
    document.getElementById('btn'+id).className = "d-none"
}

window.onload = () =>{
    document.forms['subtask'].reset();
}
