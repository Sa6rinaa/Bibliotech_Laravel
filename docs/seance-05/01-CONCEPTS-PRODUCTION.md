# 🧠 Concepts Production & Déploiement

---

## 📚 Table des matières

1. [Tests Automatisés](#tests-automatisés)
2. [Déploiement](#déploiement)
3. [Monitoring](#monitoring)
4. [Sécurité Production](#sécurité-production)

---

## Tests Automatisés

### **Types de Tests**

**Unit Tests** - Tester une classe isolée
```php
// Test qu'un User peut être créé
public function test_user_can_be_created(): void
{
    $user = User::create([...]);
    $this->assertInstanceOf(User::class, $user);
}
```

**Feature Tests** - Tester une route complète
```php
// Test que /login retourne le formulaire
public function test_login_page_loads(): void
{
    $response = $this->get('/login');
    $response->assertStatus(200);
    $response->assertViewIs('auth.login');
}
```

**Integration Tests** - Tester plusieurs composants
```php
// Test tout le flow: register → login → dashboard
public function test_user_flow(): void
{
    $this->post('/register', [...])->assertRedirect('/dashboard');
    // etc...
}
```

### **Test-Driven Development (TDD)**

```
1. Écrire test (RED - échoue)
2. Écrire code minimum (GREEN - passe)
3. Refactoriser (BLUE - meilleur code)
4. Répéter
```

---

## Déploiement

### **Environnements**

**Development** (local)
- APP_DEBUG=true
- Logs détaillés
- Database locale

**Staging** (pré-production)
- Clone production
- Tests en conditions réelles
- Pas d'utilisateurs réels

**Production** (serveur réel)
- APP_DEBUG=false
- Optimisations actives
- Monitoring

### **Types de Déploiement**

**Manual** - SSH sur serveur, git clone, artisan commands
```bash
ssh user@server.com
cd /var/www/app
git pull
php artisan migrate
```

**Automated** - CI/CD pipeline, GitHub Actions
```yaml
# GitHub Actions déclenche automatiquement
- Test code
- Build
- Deploy
```

**Blue-Green** - Deux versions simultanées
```
Requêtes → Blue (v1)
           Green (v2) 
Basculer vers Green
```

**Canary** - Déployer à 10% des users d'abord
```
10% → v2 (tester)
100% → v2 (si OK)
```

### **Processus de Déploiement**

```
1. Commit code sur GitHub
2. GitHub Actions lance tests
3. Tests passent ?
   OUI → Déployer production
   NON → Arrêter, notifier dev
4. Déploiement commence
5. Database migrations
6. Clear cache
7. Health checks
8. Si erreur → Rollback
9. Monitoring alertes
```

---

## Monitoring

### **Logs**

```
Application Logging
    ↓
File: storage/logs/laravel.log
    ↓
Analyse erreurs
    ↓
Alerte si problème critique
```

**Niveaux de log:**
- DEBUG - Info détaillée
- INFO - Événements normaux
- WARNING - Attention
- ERROR - Erreur
- CRITICAL - Critique

### **Performance Monitoring**

```
Métriques à surveiller:
- Response time (< 200ms idéal)
- CPU usage (< 70%)
- Memory (< 80%)
- Database queries (< 10ms avg)
- Error rate (< 0.1%)
```

### **Alertes**

```
Condition          Action
Error rate > 1%    Email alert
CPU > 90%          SMS alert
DB down            Page error
```

---

## Sécurité Production

### **Checklist Sécurité**

```
☑️ APP_DEBUG=false
☑️ APP_KEY configuré
☑️ HTTPS/SSL activé
☑️ CORS configuré
☑️ Rate limiting activé
☑️ CSRF tokens
☑️ Password hashing (bcrypt)
☑️ Input validation
☑️ SQL injection protection
☑️ XSS protection
```

### **HTTPS/SSL**

```
HTTP  → Pas chiffré (dangereux)
HTTPS → Chiffré avec certificat SSL
(obligatoire en production)
```

### **Environment Variables**

```
# Jamais en dur dans le code !

# .env (local, JAMAIS en git)
DB_PASSWORD=secret123

# git ne track pas .env
# donc app/config.php charge de .env

Config::get('database.Password')  // ✅ Correct
```

---

## 🔄 Cycle de Vie Complet

```
Developer          GitHub        Pipeline         Server
    ↓                 ↓              ↓               ↓
git commit       → Push code → Tests run → Artifacts
    ↓                                         ↓
    └─────────────────────────────→ Deploy  ←─
                                       ↓
                                   Health checks
                                       ↓
                                   Monitoring
                                       ↓
                                   Live!
```

---

## 📈 Métriques de Succès

```
✅ Tests: > 80% coverage
✅ Deploy: < 5 minutes
✅ Uptime: > 99.9%
✅ Response time: < 200ms
✅ Error rate: < 0.1%
```

---

Prêt pour les TP ? 🧪 → [03-TP-TESTS-CICD.md](03-TP-TESTS-CICD.md)
