#!/bin/bash
# ====================================================================
# GitHub Secrets Verification & Setup Helper
# ====================================================================
# Script ini membantu verify apakah GitHub Secrets sudah terkonfigurasi
# untuk FTP auto-deploy ke Hostinger
# ====================================================================

set -e

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

print_header() {
    echo ""
    echo -e "${BLUE}========================================${NC}"
    echo -e "${BLUE}$1${NC}"
    echo -e "${BLUE}========================================${NC}"
    echo ""
}

print_info() {
    echo -e "${BLUE}ℹ${NC} $1"
}

print_success() {
    echo -e "${GREEN}✓${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}⚠${NC} $1"
}

print_error() {
    echo -e "${RED}✗${NC} $1"
}

print_header "GitHub Secrets Verification"

# Check if gh CLI is available
if ! command -v gh &> /dev/null; then
    print_warning "GitHub CLI (gh) tidak terinstall atau tidak authenticated"
    print_info "Kita akan gunakan web browser method untuk setup secrets"
    echo ""
    
    print_header "MANUAL SETUP METHOD"
    
    echo "Ikuti langkah berikut:"
    echo ""
    echo "1️⃣  Dapatkan FTP Credentials dari Hostinger"
    echo "   ${BLUE}https://hpanel.hostinger.com${NC}"
    echo "   → Files → FTP Accounts"
    echo ""
    echo "   Copy 3 values:"
    echo "   - FTP Host (misal: ftp.majelis.info)"
    echo "   - FTP Username (misal: u123456789_majelis)"
    echo "   - FTP Password (click 'show' untuk lihat)"
    echo ""
    
    echo "2️⃣  Buka GitHub Repository Secrets"
    echo "   ${BLUE}https://github.com/cupitebet/majelis.info/settings/secrets/actions${NC}"
    echo ""
    
    echo "3️⃣  Add 3 Secrets (klik 'New repository secret' untuk masing-masing):"
    echo ""
    echo "   ${GREEN}Secret 1:${NC}"
    echo "   Name:   FTP_SERVER"
    echo "   Secret: ftp.majelis.info (atau IP dari Hostinger)"
    echo ""
    echo "   ${GREEN}Secret 2:${NC}"
    echo "   Name:   FTP_USERNAME"
    echo "   Secret: u123456789_majelis (dari Hostinger)"
    echo ""
    echo "   ${GREEN}Secret 3:${NC}"
    echo "   Name:   FTP_PASSWORD"
    echo "   Secret: [password dari Hostinger]"
    echo ""
    
    echo "4️⃣  Verify Setup"
    echo "   Setelah add 3 secrets, Anda harus lihat:"
    echo "   ${GREEN}✓${NC} FTP_SERVER"
    echo "   ${GREEN}✓${NC} FTP_USERNAME"
    echo "   ${GREEN}✓${NC} FTP_PASSWORD"
    echo ""
    
    print_header "QUICK COPY-PASTE TEMPLATE"
    
    echo "Untuk memudahkan, siapkan info ini dulu:"
    echo ""
    echo "┌────────────────────────────────────────────┐"
    echo "│ FTP Credentials (dari Hostinger)           │"
    echo "├────────────────────────────────────────────┤"
    echo "│                                            │"
    echo "│ FTP_SERVER:   _____________________        │"
    echo "│ FTP_USERNAME: _____________________        │"
    echo "│ FTP_PASSWORD: _____________________        │"
    echo "│                                            │"
    echo "└────────────────────────────────────────────┘"
    echo ""
    
    print_header "VERIFICATION CHECKLIST"
    
    echo "Setelah selesai add secrets, cek:"
    echo ""
    echo "☐ Buka: https://github.com/cupitebet/majelis.info/settings/secrets/actions"
    echo "☐ Pastikan ada 3 secrets: FTP_SERVER, FTP_USERNAME, FTP_PASSWORD"
    echo "☐ Tidak ada typo di nama secrets (exact match, case-sensitive)"
    echo "☐ Pastikan FTP credentials correct (test login via FileZilla jika perlu)"
    echo ""
    
    print_header "NEXT STEPS"
    
    echo "Setelah secrets ditambahkan:"
    echo ""
    echo "1. Test FTP deployment dengan commit kecil:"
    echo "   ${BLUE}git commit --allow-empty -m \"test: FTP auto-deploy\"${NC}"
    echo "   ${BLUE}git push origin main${NC}"
    echo ""
    echo "2. Monitor workflow di:"
    echo "   ${BLUE}https://github.com/cupitebet/majelis.info/actions${NC}"
    echo ""
    echo "3. Jika workflow success (green ✓):"
    echo "   → Auto-deploy WORKING! ✅"
    echo ""
    echo "4. Jika workflow failed (red ✗):"
    echo "   → Check logs untuk detail error"
    echo "   → Verify FTP credentials"
    echo "   → Saya bisa bantu debug"
    echo ""
    
    exit 0
fi

# If gh CLI is available, try to check secrets
print_info "Checking GitHub Secrets via CLI..."

if gh secret list &> /dev/null; then
    print_success "GitHub CLI authenticated!"
    echo ""
    
    # List secrets
    secrets=$(gh secret list | awk '{print $1}')
    
    # Check each required secret
    required_secrets=("FTP_SERVER" "FTP_USERNAME" "FTP_PASSWORD")
    missing_secrets=()
    
    for secret in "${required_secrets[@]}"; do
        if echo "$secrets" | grep -q "^${secret}$"; then
            print_success "Secret found: $secret"
        else
            print_error "Secret MISSING: $secret"
            missing_secrets+=("$secret")
        fi
    done
    
    echo ""
    
    if [ ${#missing_secrets[@]} -eq 0 ]; then
        print_success "✅ All required secrets configured!"
        echo ""
        print_info "Ready untuk test auto-deploy!"
        echo ""
        echo "Run test deployment:"
        echo "  ${BLUE}git commit --allow-empty -m \"test: FTP auto-deploy\"${NC}"
        echo "  ${BLUE}git push origin main${NC}"
        echo ""
        echo "Monitor di: ${BLUE}https://github.com/cupitebet/majelis.info/actions${NC}"
    else
        print_warning "Missing ${#missing_secrets[@]} secret(s)"
        echo ""
        print_info "Tambahkan secrets yang missing:"
        echo ""
        
        for secret in "${missing_secrets[@]}"; do
            echo "  ${BLUE}gh secret set $secret${NC}"
            echo "  (Anda akan diminta input value)"
            echo ""
        done
        
        echo "Atau add via web:"
        echo "  ${BLUE}https://github.com/cupitebet/majelis.info/settings/secrets/actions${NC}"
    fi
else
    print_error "GitHub CLI tidak authenticated"
    print_info "Authenticate dengan: ${BLUE}gh auth login${NC}"
    print_info "Atau gunakan manual web method (lihat output di atas)"
fi

echo ""
print_header "DONE"
