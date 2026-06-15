import { Link, useNavigate } from "react-router-dom";

export default function Header() {
  const navigate = useNavigate();

  const handleLogout = () => {
    localStorage.removeItem("token");
    navigate("/login");
  };

  return (
    <header style={styles.header}>
      <div style={styles.logo}>TaskAI</div>

      <nav style={styles.nav}>
        <Link to="/" style={styles.link}>Home</Link>
        <Link to="/tasks" style={styles.link}>Tasks</Link>
        <Link to="/ai" style={styles.link}>AI Assistant</Link>
        <Link to="/users" style={styles.link}>User Management</Link>

        <button onClick={handleLogout} style={styles.logout}>
          Logout
        </button>
      </nav>
    </header>
  );
}

const styles = {
  header: {
    display: "flex",
    justifyContent: "space-between",
    alignItems: "center",
    padding: "12px 20px",
    borderBottom: "1px solid #ddd",
    background: "#fff",
  },
  logo: {
    fontSize: "18px",
    fontWeight: "bold",
  },
  nav: {
    display: "flex",
    gap: "15px",
    alignItems: "center",
  },
  link: {
    textDecoration: "none",
    color: "#333",
    fontSize: "14px",
  },
  logout: {
    padding: "6px 10px",
    border: "none",
    background: "#e74c3c",
    color: "#fff",
    borderRadius: "5px",
    cursor: "pointer",
  },
};