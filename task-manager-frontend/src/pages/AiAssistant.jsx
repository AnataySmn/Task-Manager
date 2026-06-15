import { useState } from "react";
import api from "../services/api";

export default function AiAssistant() {
  const [message, setMessage] = useState("");
  const [chat, setChat] = useState([]);
  const [loading, setLoading] = useState(false);

  const sendMessage = async () => {
    if (!message.trim()) return;

    const userMessage = message;

    // show user message immediately
    setChat((prev) => [...prev, { role: "user", text: userMessage }]);
    setMessage("");
    setLoading(true);

    try {
      const res = await api.post("/ai/chat", {
        message: userMessage,
      });

      setChat((prev) => [
        ...prev,
        { role: "assistant", text: res.data.reply },
      ]);
    } catch (err) {
      console.log(err);
      setChat((prev) => [
        ...prev,
        { role: "assistant", text: "Error getting response" },
      ]);
    } finally {
      setLoading(false);
    }
  };

  return (
    <div style={styles.container}>
      <h2>AI Assistant</h2>

      <div style={styles.chatBox}>
        {chat.map((msg, i) => (
          <div
            key={i}
            style={{
              ...styles.message,
              alignSelf: msg.role === "user" ? "flex-end" : "flex-start",
              background: msg.role === "user" ? "#d1e7ff" : "#eee",
            }}
          >
            {msg.text}
          </div>
        ))}

        {loading && <p>AI is thinking...</p>}
      </div>

      <div style={styles.inputBox}>
        <input
          value={message}
          onChange={(e) => setMessage(e.target.value)}
          placeholder="Ask something..."
          style={styles.input}
        />

        <button onClick={sendMessage} style={styles.button}>
          Send
        </button>
      </div>
    </div>
  );
}

const styles = {
  container: {
    maxWidth: 600,
    margin: "0 auto",
  },
  chatBox: {
    height: 400,
    border: "1px solid #ddd",
    padding: 10,
    display: "flex",
    flexDirection: "column",
    overflowY: "auto",
    marginBottom: 10,
  },
  message: {
    padding: 10,
    borderRadius: 8,
    marginBottom: 8,
    maxWidth: "70%",
  },
  inputBox: {
    display: "flex",
    gap: 10,
  },
  input: {
    flex: 1,
    padding: 10,
  },
  button: {
    padding: "10px 15px",
    cursor: "pointer",
  },
};