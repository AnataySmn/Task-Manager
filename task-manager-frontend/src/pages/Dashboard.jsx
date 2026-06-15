import { useState, useEffect } from "react";
import axios from "axios";

export default function Dashboard() {
  const [tasks, setTasks] = useState([]);
  const [loading, setLoading] = useState(true);
  const [title, setTitle] = useState("");

  useEffect(() => {
    loadTasks();
  }, []);

  const loadTasks = async () => {
    try {
      const token = localStorage.getItem("token");

      const res = await axios.get(
        "http://localhost:8000/api/tasks",
        {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        }
      );

      setTasks(res.data);
    } catch (err) {
      console.log("Error loading tasks:", err);
    } finally {
      setLoading(false);
    }
  };

  const createTask = async () => {
    try {
      const token = localStorage.getItem("token");

      const res = await axios.post(
        "http://localhost:8000/api/tasks",
        {
          title,
          description: title,
          status: "Pending",
          due_date: "2026-06-20",
        },
        {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        }
      );

      setTasks([...tasks, res.data]);
      setTitle("");
    } catch (err) {
      console.log("Create error:", err.response?.data);
    }
  };

  const completeTask = async (task) => {
    try {
      const token = localStorage.getItem("token");

      const res = await axios.put(
        `http://localhost:8000/api/tasks/${task.id}`,
        {
          ...task,
          status: "Completed",
        },
        {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        }
      );

      setTasks(
        tasks.map((t) =>
          t.id === task.id ? res.data : t
        )
      );
    } catch (err) {
      console.log("Update error:", err.response?.data);
    }
  };

  const deleteTask = async (id) => {
    try {
      const token = localStorage.getItem("token");

      await axios.delete(
        `http://localhost:8000/api/tasks/${id}`,
        {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        }
      );

      setTasks(tasks.filter((task) => task.id !== id));
    } catch (err) {
      console.log("Delete error:", err.response?.data);
    }
  };

  if (loading) {
    return (
      <div>
        <h1>Dashboard</h1>
        <p>Loading tasks...</p>
      </div>
    );
  }

 return (
  <div
    style={{
      minHeight: "100vh",
      background: "#f5f7fb",
      padding: "40px",
      fontFamily: "Arial, sans-serif",
    }}
  >
    <h1
      style={{
        textAlign: "center",
        marginBottom: "30px",
      }}
    >
      Task Management Dashboard
    </h1>

    <div
      style={{
        background: "white",
        padding: "20px",
        borderRadius: "12px",
        marginBottom: "20px",
        boxShadow: "0 2px 10px rgba(0,0,0,0.1)",
      }}
    >
      <input
        type="text"
        placeholder="Enter task title"
        value={title}
        onChange={(e) => setTitle(e.target.value)}
        style={{
          padding: "10px",
          width: "70%",
          borderRadius: "8px",
          border: "1px solid #ddd",
        }}
      />

      <button
        onClick={createTask}
        style={{
          marginLeft: "10px",
          padding: "10px 20px",
          border: "none",
          borderRadius: "8px",
          cursor: "pointer",
        }}
      >
        Add Task
      </button>
    </div>

    {tasks.map((task) => (
      <div
        key={task.id}
        style={{
          background: "white",
          padding: "20px",
          borderRadius: "12px",
          marginBottom: "15px",
          boxShadow: "0 2px 10px rgba(0,0,0,0.1)",
        }}
      >
        <h3>{task.title}</h3>

        <p>{task.description}</p>

        <p>
          <strong>Status:</strong> {task.status}
        </p>

        <p>
          <strong>Due:</strong> {task.due_date}
        </p>

        <button
          onClick={() => completeTask(task)}
          style={{
            padding: "8px 16px",
            borderRadius: "8px",
            border: "none",
            marginRight: "10px",
            cursor: "pointer",
          }}
        >
          Complete
        </button>

        <button
          onClick={() => deleteTask(task.id)}
          style={{
            padding: "8px 16px",
            borderRadius: "8px",
            border: "none",
            cursor: "pointer",
          }}
        >
          Delete
        </button>
      </div>
    ))}
  </div>
)
}