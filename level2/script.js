let tasks = JSON.parse(localStorage.getItem("tasks")) || [];

document.addEventListener("DOMContentLoaded", () => {
  document.getElementById("addBtn").addEventListener("click", addTask);
  renderTasks();
});

function renderTasks() {
  const taskList = document.getElementById("taskList");
  taskList.innerHTML = "";

  tasks.forEach((task, index) => {
    const li = document.createElement("li");

    const taskContainer = document.createElement("div");
    taskContainer.style.flexGrow = "1";

    if (task.editing) {
      const input = document.createElement("input");
      input.type = "text";
      input.value = task.text;
      input.style.width = "100%";
      input.onchange = (e) => (task.text = e.target.value);
      taskContainer.appendChild(input);
    } else {
      const text = document.createElement("span");
      text.textContent = task.text;

      if (task.dueDate) {
        const date = document.createElement("small");
        date.textContent = " (Due: " + task.dueDate + ")";
        date.style.marginLeft = "10px";
        text.appendChild(date);
      }

      if (task.completed) {
        text.style.textDecoration = "line-through";
      }

      taskContainer.appendChild(text);
    }

    const buttons = document.createElement("div");

    const completeBtn = document.createElement("button");
    completeBtn.textContent = task.completed ? "Undo" : "Done";
    completeBtn.onclick = () => toggleComplete(index);
    buttons.appendChild(completeBtn);

    const editBtn = document.createElement("button");
    editBtn.textContent = task.editing ? "Save" : "Edit";
    editBtn.onclick = () => toggleEdit(index);
    buttons.appendChild(editBtn);

    const deleteBtn = document.createElement("button");
    deleteBtn.textContent = "Delete";
    deleteBtn.style.backgroundColor = "red";
    deleteBtn.onclick = () => deleteTask(index);
    buttons.appendChild(deleteBtn);

    li.appendChild(taskContainer);
    li.appendChild(buttons);
    taskList.appendChild(li);
  });
}

function addTask() {
  const taskInput = document.getElementById("taskInput");
  const dueDateInput = document.getElementById("dueDateInput");

  const taskText = taskInput.value.trim();
  const dueDate = dueDateInput.value;

  if (taskText === "") return;

  tasks.push({
    text: taskText,
    dueDate: dueDate,
    completed: false,
    editing: false
  });

  taskInput.value = "";
  dueDateInput.value = "";
  saveTasks();
}

function toggleComplete(index) {
  tasks[index].completed = !tasks[index].completed;
  saveTasks();
}

function toggleEdit(index) {
  tasks[index].editing = !tasks[index].editing;
  saveTasks();
}

function deleteTask(index) {
  tasks.splice(index, 1);
  saveTasks();
}

function saveTasks() {
  localStorage.setItem("tasks", JSON.stringify(tasks));
  renderTasks();
}