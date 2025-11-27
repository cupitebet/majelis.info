#!/bin/bash
# ====================================================================
# Fix Nested public_html Deployment
# ====================================================================
# Script ini memindahkan semua files dari public_html/public_html
# ke public_html (root level) untuk fix Git deployment path issue
# ====================================================================

set -e

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

print_header "Fix Nested public_html Deployment"

# SSH connection details (you'll need to provide these)
echo "This script will guide you to fix the nested public_html issue."
echo ""
print_warning "You need SSH access to Hostinger to run this script."
echo ""

# Check if we have SSH details
echo "Please provide your Hostinger SSH details:"
echo ""
read -p "SSH Username (e.g., u123456789): " SSH_USER
read -p "SSH Host (e.g., majelis.info or IP): " SSH_HOST
echo ""

print_info "Testing SSH connection..."

# Test SSH connection
if ssh -o ConnectTimeout=5 -o BatchMode=yes "$SSH_USER@$SSH_HOST" exit 2>/dev/null; then
    print_success "SSH connection successful!"
else
    print_error "Cannot connect via SSH."
    print_warning "Please run these commands manually in Hostinger SSH terminal:"
    echo ""
    echo -e "${BLUE}# 1. Login to SSH:${NC}"
    echo "ssh $SSH_USER@$SSH_HOST"
    echo ""
    echo -e "${BLUE}# 2. Run these commands:${NC}"
    echo ""
    echo "# Backup current public_html"
    echo "mv public_html public_html_backup_\$(date +%Y%m%d_%H%M%S)"
    echo ""
    echo "# Move nested public_html to correct location"
    echo "mv public_html_backup_*/public_html public_html"
    echo ""
    echo "# Verify files are in correct location"
    echo "ls -la public_html/"
    echo ""
    echo "# If everything looks good, remove backup"
    echo "# rm -rf public_html_backup_*"
    echo ""
    exit 1
fi

print_info "Proceeding with automatic fix..."

# Create commands to run on server
COMMANDS=$(cat <<'EOF'
# Backup current public_html
BACKUP_NAME="public_html_backup_$(date +%Y%m%d_%H%M%S)"
echo "Creating backup: $BACKUP_NAME"
mv public_html "$BACKUP_NAME"

# Move nested public_html to correct location
echo "Moving files from nested public_html..."
mv "$BACKUP_NAME/public_html" public_html

# Verify
echo ""
echo "Files now in public_html (root level):"
ls -la public_html/ | head -20

echo ""
echo "✓ Fix complete!"
echo ""
echo "Backup location: $BACKUP_NAME"
echo "You can delete backup with: rm -rf $BACKUP_NAME"
EOF
)

# Execute commands on server
print_info "Executing fix on server..."
ssh "$SSH_USER@$SSH_HOST" "$COMMANDS"

print_success "Done!"
echo ""
print_info "Next steps:"
echo "  1. Visit https://majelis.info to verify website works"
echo "  2. If everything OK, delete backup folder via SSH or File Manager"
echo "  3. Test auto-deployment by pushing to GitHub"
echo ""
