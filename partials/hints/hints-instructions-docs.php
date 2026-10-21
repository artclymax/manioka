<?php
$page = $args['page'] ?? get_queried_object();
$top_label = get_field('hints_docs_top_label', $page) ?? '';
$title = get_field('hints_docs_title', $page) ?? '';
$descr = get_field('hints_docs_descr', $page) ?? '';

$title_prepare = get_field('hints_docs_prepare_title', $page) ?? '';
$title_process = get_field('hints_docs_process_title', $page) ?? '';

$prepare_docs = get_field('hints_docs_prepare', $page) ?? [];
$process_docs = get_field('hints_docs_process', $page) ?? [];
?>

<?php if ($title || !empty($prepare_docs) || !empty($process_docs)): ?>
	<section class="section hints-instructions-docs" id="hints-instructions-docs">
		<div class="container hints-instructions-docs__container">
			<?php get_template_part('partials/section-header', null, [
				'label' => $top_label,
				'title' => $title,
				'descr' => $descr
			]); ?>
			<div class="hints-instructions-docs__grid">
					<?php if (!empty($prepare_docs)): ?>
					<div class="hints-instructions-docs__column">
						<div class="hints-instructions-docs__column-label label">
								<?php echo esc_html($title_prepare) ?>
						</div>
						<ul class="hints-instructions-docs__list">
								<?php foreach ($prepare_docs as $doc):
									$doc_text = $doc['text'] ?? '';
									if (!$doc_text)
										continue;
									?>
								<li class="hints-instructions-docs__item title-4">
										<?php echo esc_html($doc_text); ?>
								</li>
								<?php endforeach; ?>
						</ul>
					</div>
					<?php endif; ?>

					<?php if (!empty($process_docs)): ?>
					<div class="hints-instructions-docs__column">
						<div class="hints-instructions-docs__column-label label">
								<?php echo esc_html($title_process) ?>
						</div>
						<ul class="hints-instructions-docs__list">
								<?php foreach ($process_docs as $doc):
									$doc_text = $doc['text'] ?? '';
									if (!$doc_text)
										continue;
									?>
								<li class="hints-instructions-docs__item title-4">
										<?php echo esc_html($doc_text); ?>
								</li>
								<?php endforeach; ?>
						</ul>
					</div>
					<?php endif; ?>
			</div>
		</div>
	</section>
<?php endif; ?>