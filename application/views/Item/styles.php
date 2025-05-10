<style>
  :root {
    --primary-color: #4361ee;
    --secondary-color: #3f37c9;
    --accent-color: #4895ef;
    --light-color: #f8f9fa;
    --dark-color: #212529;
    --danger-color: #f72585;
    --success-color: #4cc9f0;
    --border-color: #dee2e6;
    --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }
  
  * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }
  
  body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.6;
    color: var(--dark-color);
    background-color: #f5f7fa;
    padding: 2rem;
  }
  
  .container {
    max-width: 1200px;
    margin: 0 auto;
  }
  
  h1, h2, h3 {
    color: var(--primary-color);
    margin-bottom: 1.5rem;
  }
  
  /* Navigation */
  .nav-menu {
    display: flex;
    gap: 1rem;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--border-color);
  }
  
  .nav-link {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 600;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    transition: all 0.3s;
  }
  
  .nav-link:hover {
    background-color: rgba(67, 97, 238, 0.1);
    text-decoration: underline;
  }
  
  /* Form Styles */
  .form-container {
    background: white;
    border-radius: 8px;
    padding: 2rem;
    margin-bottom: 3rem;
    box-shadow: var(--shadow);
  }
  
  .form-group {
    margin-bottom: 1.5rem;
  }
  
  label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: var(--secondary-color);
  }
  
  input[type="text"],
  input[type="number"],
  select,
  textarea {
    width: 100%;
    padding: 0.75rem 1rem;
    border: 1px solid var(--border-color);
    border-radius: 4px;
    font-size: 1rem;
    transition: border-color 0.3s;
  }
  
  textarea {
    min-height: 100px;
    resize: vertical;
  }
  
  input[type="text"]:focus,
  input[type="number"]:focus,
  select:focus,
  textarea:focus {
    outline: none;
    border-color: var(--accent-color);
    box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
  }
  
  /* Buttons */
  .btn {
    display: inline-block;
    background-color: var(--primary-color);
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 4px;
    cursor: pointer;
    font-size: 1rem;
    font-weight: 600;
    transition: all 0.3s;
    text-decoration: none;
    text-align: center;
  }
  
  .btn:hover {
    background-color: var(--secondary-color);
    transform: translateY(-2px);
  }
  
  .btn-danger {
    background-color: var(--danger-color);
  }
  
  .btn-danger:hover {
    background-color: #d3166d;
  }
  
  /* Table Styles */
  .table-container {
    background: white;
    border-radius: 8px;
    padding: 2rem;
    box-shadow: var(--shadow);
    overflow-x: auto;
    margin-bottom: 2rem;
  }
  
  table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem;
  }
  
  th, td {
    padding: 1rem;
    text-align: left;
    border-bottom: 1px solid var(--border-color);
  }
  
  th {
    background-color: var(--primary-color);
    color: white;
    font-weight: 600;
  }
  
  tr:nth-child(even) {
    background-color: var(--light-color);
  }
  
  tr:hover {
    background-color: rgba(67, 97, 238, 0.05);
  }
  
  /* Responsive Design */
  @media (max-width: 768px) {
    body {
      padding: 1rem;
    }
    
    .form-container, .table-container {
      padding: 1.5rem;
    }
    
    th, td {
      padding: 0.75rem;
    }
    
    .nav-menu {
      flex-direction: column;
      gap: 0.5rem;
    }
  }
  
  /* Utility Classes */
  .mb-3 {
    margin-bottom: 1.5rem;
  }
  
  .text-center {
    text-align: center;
  }
</style>