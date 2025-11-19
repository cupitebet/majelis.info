#!/bin/bash

# Flutter App Quick Setup Script
# majelis.info Mobile App Automation

set -e

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

echo -e "${BLUE}========================================${NC}"
echo -e "${BLUE}  Majelis.info Flutter App Setup${NC}"
echo -e "${BLUE}========================================${NC}"
echo ""

# Check if Flutter is installed
if ! command -v flutter &> /dev/null; then
    echo -e "${RED}✗ Flutter not found!${NC}"
    echo ""
    echo "Please install Flutter first:"
    echo "https://flutter.dev/docs/get-started/install"
    exit 1
fi

echo -e "${GREEN}✓ Flutter found: $(flutter --version | head -n 1)${NC}"
echo ""

# Ask for project location
read -p "Enter project directory (default: ~/projects): " PROJECT_DIR
PROJECT_DIR=${PROJECT_DIR:-~/projects}

# Create directory if not exists
mkdir -p "$PROJECT_DIR"
cd "$PROJECT_DIR"

echo -e "${BLUE}Creating Flutter project...${NC}"
flutter create appmobilewordpress

cd appmobilewordpress

echo -e "${GREEN}✓ Flutter project created${NC}"
echo ""

# Copy files from repository
REPO_PATH=$(dirname "$(dirname "$(readlink -f "$0")")")
FLUTTER_STRUCTURE="$REPO_PATH/flutter-app-structure"

if [ -d "$FLUTTER_STRUCTURE" ]; then
    echo -e "${BLUE}Copying project files...${NC}"

    # Copy pubspec.yaml
    cp "$FLUTTER_STRUCTURE/pubspec.yaml" .
    echo -e "${GREEN}✓ Copied pubspec.yaml${NC}"

    # Copy lib files
    cp -r "$FLUTTER_STRUCTURE/lib/"* lib/
    echo -e "${GREEN}✓ Copied lib files${NC}"

    echo ""
    echo -e "${BLUE}Installing dependencies...${NC}"
    flutter pub get
    echo -e "${GREEN}✓ Dependencies installed${NC}"

else
    echo -e "${YELLOW}⚠ flutter-app-structure folder not found${NC}"
    echo "Please manually copy files from:"
    echo "$REPO_PATH/flutter-app-structure/"
fi

echo ""
echo -e "${BLUE}========================================${NC}"
echo -e "${GREEN}✓ Setup Complete!${NC}"
echo -e "${BLUE}========================================${NC}"
echo ""
echo "Project location: $PROJECT_DIR/appmobilewordpress"
echo ""
echo "Next steps:"
echo "1. cd $PROJECT_DIR/appmobilewordpress"
echo "2. flutter run"
echo ""
echo -e "${YELLOW}Pro tips:${NC}"
echo "• Open in VS Code: code ."
echo "• Check devices: flutter devices"
echo "• Run on specific device: flutter run -d <device_id>"
echo "• Hot reload: Press 'r' when app is running"
echo "• Hot restart: Press 'R' when app is running"
echo ""
echo -e "${GREEN}Happy coding! 🚀${NC}"
