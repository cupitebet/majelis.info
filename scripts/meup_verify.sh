#!/usr/bin/env bash
set -euo pipefail

SITE="https://majelis.info"
MEUP_NS="$SITE/wp-json/meup/v1"
WP_NS="$SITE/wp-json/wp/v2"
ROOT="$SITE/wp-json/"

report_file="/tmp/meup-verify-$(date +%s).txt"

echo "MeUp Verification Report" > "$report_file"
echo "Site: $SITE" >> "$report_file"
echo "Generated: $(date -u)" >> "$report_file"
echo "" >> "$report_file"

check() {
  local name=$1
  local url=$2
  printf "Checking %-20s " "$name" | tee -a "$report_file"
  if curl -sSf --max-time 10 "$url" >/dev/null 2>&1; then
    echo "OK" | tee -a "$report_file"
  else
    echo "FAIL" | tee -a "$report_file"
    echo "  -> Tried: $url" >> "$report_file"
  fi
}

# Check root namespaces
echo "Namespaces (wp-json root):" | tee -a "$report_file"
if curl -sSf "$ROOT" | jq -r 'keys | .[]' > /tmp/_namespaces 2>/dev/null; then
  jq -r 'keys | .[]' <(curl -s "$ROOT") | tee -a "$report_file"
else
  echo "  (failed to fetch root)" | tee -a "$report_file"
fi

echo "" | tee -a "$report_file"

# Check MeUp endpoints
check "meup/events" "$MEUP_NS/events"
check "meup/event-cats" "$MEUP_NS/event-categories"

# Check WP endpoints
check "wp/posts (v2)" "$WP_NS/posts"

# Check JWT auth (token) endpoint existence (not testing credentials)
check "jwt-auth token" "$SITE/wp-json/jwt-auth/v1/token"

# Quick sample fetch for events (show first id/title if available)
echo "\nSample data (meup/events):" | tee -a "$report_file"
if curl -sSf "$MEUP_NS/events" >/tmp/_events 2>/dev/null; then
  if command -v jq >/dev/null 2>&1; then
    jq 'if type=="array" and length>0 then {id:.[0].id, title:.[0].title} else . end' /tmp/_events | tee -a "$report_file"
  else
    head -c 400 /tmp/_events | tee -a "$report_file"
  fi
else
  echo "  (failed to fetch events or empty)" | tee -a "$report_file"
fi

# Summary
echo "\nSummary:" | tee -a "$report_file"
echo "  Report saved to: $report_file" | tee -a "$report_file"

echo "\n--- OUTPUT ---\n"
cat "$report_file"

exit 0
