<style>

    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: "Poppins", sans-serif;
}

.sidebar {
  position: fixed;
  left: 0;
  top: 0;
  height: 100%;
  width: 78px;
  background: #1e4356;
  padding: 6px 14px;
  z-index: 99;
  transition: all 0.5s ease;
}

.sidebar.open {
  width: 250px;
}

.sidebar .logo-details {
  height: 60px;
  display: flex;
  align-items: center;
  position: relative;
}

.sidebar .logo-details .icon {
  opacity: 0;
  transition: all 0.5s ease;
}

.sidebar .logo-details .logo_name {
  color: #fff;
  font-size: 20px;
  font-weight: 600;
  opacity: 0;
  transition: all 0.5s ease;
}

.sidebar.open .logo-details .icon,
.sidebar.open .logo-details .logo_name {
  opacity: 1;
}

.sidebar .logo-details #btn {
  position: absolute;
  top: 50%;
  right: 0;
  transform: translateY(-50%);
  font-size: 22px;
  cursor: pointer;
  transition: all 0.5s ease;
}

.sidebar.open .logo-details #btn {
  text-align: right;
}

.sidebar i {
  color: #fff;
  height: 60px;
  min-width: 30px;
  font-size: 28px;
  line-height: 60px;
}

.sidebar .nav-list {
  margin-top: 20px;
  height: 100%;
}

.sidebar li {
  position: relative;
  margin: 8px 0;
  list-style: none;
}

.sidebar li .tooltip {
  position: absolute;
  top: -20px;
  left: calc(100% + 15px);
  z-index: 3;
  background: #fff;
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.3);
  padding: 6px 12px;
  border-radius: 4px;
  font-size: 15px;
  font-weight: 400;
  opacity: 0;
  white-space: nowrap;
  pointer-events: none;
  transition: 0s;
}

.sidebar li:hover .tooltip {
  opacity: 1;
  pointer-events: auto;
  transition: all 0.4s ease;
  top: 50%;
  transform: translateY(-50%);
}

.sidebar.open li .tooltip {
  display: none;
}

.sidebar li a {
  display: flex;
  height: 100%;
  width: 100%;
  border-radius: 12px;
  align-items: center;
  text-decoration: none;
  transition: all 0.4s ease;
  background: #1e4356;
}

.sidebar li a:hover {
  background: #285c73;
}

.sidebar li a .links_name {
  color: #fff;
  font-size: 15px;
  font-weight: 400;
  white-space: nowrap;
  opacity: 0;
  pointer-events: none;
  transition: 0.4s;
}

.sidebar.open li a .links_name {
  opacity: 1;
  pointer-events: auto;
}

.sidebar li a:hover .links_name,
.sidebar li a:hover i {
  transition: all 0.5s ease;
  color: #fff;
}

.sidebar li i {
  height: 50px;
  line-height: 50px;
  font-size: 18px;
  border-radius: 12px;
}

/* === HOME BUTTON KHUSUS === */
.sidebar li.home-button {
  position: fixed;
  bottom: 70px; /* di atas profile */
  left: 0;
  width: 78px;
  transition: all 0.5s ease;
}

.sidebar.open li.home-button {
  width: 250px;
}

.sidebar li.home-button a {
  background: #285c73;
  color: #fff;
  font-weight: 500;
  justify-content: center;
  text-align: center;
  padding: 10px;
  border-radius: 8px;
  transition: background 0.3s ease;
}

.sidebar li.home-button a:hover {
  background: #327491;
}

/* === PROFILE === */
.sidebar li.profile {
  position: fixed;
  height: 60px;
  width: 78px;
  left: 0;
  bottom: -8px;
  padding: 10px 14px;
  background: #163544;
  transition: all 0.5s ease;
  overflow: hidden;
}

.sidebar.open li.profile {
  width: 250px;
}

.sidebar li .profile-details {
  display: flex;
  align-items: center;
  flex-wrap: nowrap;
}

.sidebar li img {
  height: 45px;
  width: 45px;
  object-fit: cover;
  border-radius: 6px;
  margin-right: 10px;
}

.sidebar li.profile .name,
.sidebar li.profile .job {
  font-size: 15px;
  font-weight: 400;
  color: #fff;
  white-space: nowrap;
}

.sidebar li.profile .job {
  font-size: 12px;
}

.sidebar .profile #log_out {
  position: absolute;
  top: 50%;
  right: 0;
  transform: translateY(-50%);
  background: #163544;
  width: 100%;
  height: 60px;
  line-height: 60px;
  border-radius: 0px;
  transition: all 0.5s ease;
}

.sidebar .profile #log_out:hover {
  color: red;
}

.sidebar.open .profile #log_out {
  width: 50px;
  background: none;
}

/* === SAAT SIDEBAR TERTUTUP === */
.sidebar:not(.open) li a {
  display: flex;
  justify-content: center;   
  align-items: center;       
  padding: 0;                
}

.sidebar:not(.open) li a .links_name {
  display: none;
}

/* HOME button tetap khusus */
.sidebar li.home-button a {
  background: #285c73;
  color: #fff;
  font-weight: 500;
  border-radius: 8px;
  transition: background 0.3s ease;
  justify-content: center; 
}

.sidebar li.home-button a:hover {
  background: #327491;
}

@media (max-width: 420px) {
  .sidebar li .tooltip {
    display: none;
  }
}

.modal {
  display: none;
  position: fixed;
  inset: 0;
  z-index: 1000;
  background: rgba(0, 0, 0, 0.55);
  backdrop-filter: blur(6px);
  animation: fadeIn 0.3s ease;
}

/* === Modal Box === */
.modal-content {
  background: rgba(30, 67, 86, 0.85);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(255,255,255,0.2);
  border-radius: 16px;
  padding: 25px;
  width: 340px;
  margin: 15% auto;
  text-align: center;
  color: #fff;
  box-shadow: 0 8px 32px rgba(0,0,0,0.2);
  animation: scaleUp 0.3s ease;
  font-family: "Poppins", sans-serif;
}

/* === Title & Text === */
.modal-content h3 {
  font-size: 18px;
  font-weight: 600;
  margin-bottom: 8px;
}
.modal-content p {
  font-size: 14px;
  font-weight: 400;
  opacity: 0.85;
  margin-bottom: 20px;
}

/* === Button Group === */
.modal-actions {
  display: flex;
  justify-content: center;
  gap: 12px;
}
.btn {
  padding: 10px 18px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  font-weight: 500;
  font-size: 14px;
  transition: all 0.3s ease;
}
.btn-danger {
  background: #e63946;
  color: #fff;
}
.btn-danger:hover {
  background: #c1121f;
}
.btn-secondary {
  background: #6c757d;
  color: #fff;
}
.btn-secondary:hover {
  background: #495057;
}
    </style>